<?php
/********************
 * �߸�Ĵ������
 *
 *
 * �ѹ�����
 *    2006/07/11 (kaji)
 *      ����ȿž��󥯥���å�����$ware_id�򥻥å�
 *      �����ʥޥ����ξ��ʤ�ɽ���ܥ���
 *    2006/07/12 (kaji)
 *      ��Ĵ����ͳ�򥻥쥯�ȥܥå������ѹ�
 *      ���ܥ���̾���ѹ�
 *      ��Ĵ����ͳ��DB����Ͽ����Ƥ��ʤ��ä�
 *      ����å��������ɲ�
 *      ����λ�ܥ���إ�󥯤��ɲ�
 *    2006/07/13
 *      �������ǽ�κ��
 *    2006/07/14
 *      �����Ū��ͭ�����ʰʳ���ɽ������褦���ѹ�
 *    2006/10/13 (watanabe-k)
 *      ���߸˿����SQL��stock_cd�ˡ�-�Ǥ��ɲä�����     
 *    2006/11/30 (suzuki)
 *      ���߸�ñ�����SQL��ñ���ơ��֥�Ȥη�������     
********************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/04/02      B0702-023   kajioka-h   ľ�Ĥ�ľ�ĤΤ�ͭ�����ʤ��Ȥ��ʤ��Х�����
 *                  B0702-026   kajioka-h   �߸˴������ʤ����ʤ��Ȥ���Х�����
 *  2007/04/17      B0702-038   kajioka-h   Ĵ��ñ������Ͽ����Ƥ��ʤ��Х�����
 *  2009/10/12                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *  2015/05/01                  amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */

$page_title = "�߸�Ĵ��";

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "dateForm","POST","$_SERVER[PHP_SELF]");
/****************************/
//�����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];
//$shop_gid = $_SESSION["shop_gid"];
$staff_id = $_SESSION["staff_id"];
$group_kind = $_SESSION["group_kind"];

/****************************/
//�������
/****************************/
//ɽ���Կ�
if(isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}
//����Կ�
//$del_history[] = null;

$ware_name = $_POST["form_ware_name"];

if($_POST["form_ware"] != null){
    $ware_id = $_POST["form_ware"];
}

/****************************/
//���ʤ�����ɽ���ܥ��󲡲�����
/****************************/
/*
if($_POST["allgoods_button_flg"] == true){
    $max_row = 5;
    $ware_name = "";
    $ware_id = $_POST["form_ware"];

    //�Ҹˤ����򤵤줤����
    if($ware_id != null)
    {
        //SQL����
        $sql  = "SELECT";
        $sql .= "   t_goods.goods_id,";
        $sql .= "   t_goods.goods_cd,";
        $sql .= "   t_goods.goods_name,";
        $sql .= "   t_goods.unit,";
        $sql .= "   COALESCE(t_stock.stock_num,0),";
        $sql .= "   COALESCE(t_stock.rstock_num,0),";
        $sql .= "   t_ware.ware_name,";
        $sql .= "   t_ware.ware_id";
        $sql .= " FROM";
        $sql .= "   t_goods,";
        $sql .= "   t_stock,";
        $sql .= "   t_ware";
        $sql .= " WHERE";
        $sql .= "   t_stock.ware_id = $ware_id";
        $sql .= "   AND";
        $sql .= "   t_stock.goods_id = t_goods.goods_id";
        $sql .= "   AND";
        //$sql .= "   t_stock.shop_id = $shop_id";
        if($_SESSION[group_kind] == "2"){
            $sql .= "   t_stock.shop_id IN (".Rank_Sql().") ";
        }else{
            $sql .= "   t_stock.shop_id = $_SESSION[client_id]";
        }

        $sql .= "   AND";
        $sql .= "   t_goods.stock_manage = '1'";
        $sql .= "   AND";
        $sql .= "   t_stock.ware_id = t_ware.ware_id";
        $sql .= "   ORDER BY t_goods.goods_cd";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $data_num = pg_num_rows($result);

        if($data_num > 0){
            //�ǡ�������
            for($i = 0; $i < $data_num; $i++){
                if($i < $data_num){
                    $goods_data[] = pg_fetch_array($result, $i, PGSQL_NUM);
                }else{
                    //�ҥåȷ������̤���ξ��϶�������
                    for($j = 0; $j < 7; $j++){
                        $goods_data[$i][$j] = "";
                    }
                }
            }
            //����Կ�
            if($max_row > $data_num){
                $max_row = 5;
            }else{
                $max_row = $data_num;    
            }
        }
    }
    //�����ǡ����������
    for($i = 0; $i < $max_row; $i++){

        for($j = 0; $j < 7; $j++){
            //�����å�
            if($goods_data[$i][$j] == null){
                $goods_data[$i][$j] = "";
            }
        }

/*
        //()��Ĥ������
        if($goods_data[$i][5] != null){
            $goods_data[$i][5] = "(".$goods_data[$i][5].")";
        }else{
            $goods_data[$i][5] = "";
        }

        $goods_defo_data["form_io_type"][$i]            = "1";
        $goods_defo_data["form_goods_id"][$i]           = $goods_data[$i][0];
        $goods_defo_data["form_goods_cd"][$i]           = $goods_data[$i][1];
        $goods_defo_data["form_goods_name"][$i]         = $goods_data[$i][2];
        $goods_defo_data["form_adjust_num"][$i]         = "0";
        $goods_defo_data["form_unit"][$i]               = $goods_data[$i][3];
        $goods_defo_data["form_b_stock_num"][$i]        = $goods_data[$i][4];
        $goods_defo_data["form_b_rstock_num"][$i]       = $goods_data[$i][5];
        $goods_defo_data["form_a_stock_num"][$i]        = $goods_data[$i][4];
        $goods_defo_data["form_a_rstock_num"][$i]       = $goods_data[$i][5];
    }

    //�Ҹ�̾
    $ware_name = $goods_data[0][6];
    $goods_defo_date["form_ware_name"] = $ware_name;

    //�Ҹ�ID��hidden�˽񤭹���
    $goods_defo_data["form_ware_id"] = $ware_id;

    //�������򥯥ꥢ
//    $del_hisotry = array(null);
//    $goods_defo_data["del_row"] = "";
    $goods_defo_data["allgoods_button_flg"] = "";
//    $_POST["del_row"] = "";

    //�������줿�ǡ����򥻥å�
    $form->setConstants($goods_defo_data);
}


/****************************/
//�о��Ҹ��ѹ�
/****************************/
if($_POST["show_button_flg"] == "true"){
    $ware_id = $_POST["form_ware"];             //�Ҹ�ID
    $ware_name = "";
    $type      = $_POST["form_type"];             //����

    $adjust_yy = $_POST["form_adjust_day"]["y"];    //ǯ
    $adjust_mm = $_POST["form_adjust_day"]["m"];    //��
    $adjust_dd = $_POST["form_adjust_day"]["d"];    //��

    //�������ϥ����å�
    if($adjust_yy == null || $adjust_mm == null || $adjust_dd == null){
        $adjust_day_err = "Ĵ���������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //����Ⱦ�ѥ����å�
    if(!ereg("^[0-9]+$", $adjust_yy)
        ||
        !ereg("^[0-9]+$", $adjust_mm)
        ||
        !ereg("^[0-9]+$", $adjust_dd)
    ){
        $adjust_day_err = "Ĵ���������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //���������������å�
    if(!checkdate((int)$adjust_mm, (int)$adjust_dd, (int)$adjust_yy)){
        $adjust_day_err = "Ĵ���������դ������ǤϤ���ޤ���";
        $err_flg = true;
     }elseif($err_flg != true){
        $adjust_day_err = Sys_Start_Date_Chk($adjust_yy, $adjust_mm, $adjust_dd, "Ĵ����");
        if($adjust_day_err != null){
            $adjust_day_err = "Ĵ���������դ������ǤϤ���ޤ���";
            $err_flg = true;
        }else{
            $sql = "SELECT MAX(close_day) FROM t_sys_renew WHERE renew_div = '2' AND shop_id = $shop_id;";
            $result = Db_Query($conn, $sql);
            $close_day_last = (pg_fetch_result($result, 0, 0) != null) ? pg_fetch_result($result, 0, 0) : START_DAY;
            $adjust_yy = str_pad($adjust_yy, 4, 0, STR_PAD_LEFT);
            $adjust_mm = str_pad($adjust_mm, 2, 0, STR_PAD_LEFT);
            $adjust_dd = str_pad($adjust_dd, 2, 0, STR_PAD_LEFT);

            if($adjust_yy."-".$adjust_mm."-".$adjust_dd <= $close_day_last){
                $adjust_day_err = "Ĵ���� �ϡ���������ǯ���� ���������դ����Ϥ��Ƥ���������";
                $err_flg = true;
            }
        }
    }
    //���顼�ե饰
    $err_flg = ($ware_id == null || $err_flg == true)? true : false;    //���顼�ե饰��FALSE�ξ��Τ߽�������

    if($err_flg == false){
    //���դ���
    $adjust_date = $adjust_yy."-".$adjust_mm."-".$adjust_dd;

    //�Ҹ�̾�����
    $sql  = "SELECT";
    $sql .= "   ware_name";
    $sql .= " FROM";
    $sql .= "   t_ware";
    $sql .= " WHERE";
    $sql .= "   ware_id = $ware_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $ware_name = pg_fetch_result($result, 0,0);

        for($i = 0; $i < $max_row; $i++){
            $goods_id[$i]   = $_POST["form_goods_id"][$i];

            if($goods_id[$i] != null){

                $sql  = "SELECT";
                $sql .= "   t_goods.goods_id,";
                $sql .= "   t_goods.goods_cd,";
                $sql .= "   t_goods.goods_name,";
                $sql .= "   t_goods.unit,";
                $sql .= "   COALESCE(t_stock.stock_num,0),";
                $sql .= "   COALESCE(t_stock.rstock_num,0)";
                $sql .= " FROM";
                $sql .= "   t_goods";
                $sql .= "       LEFT JOIN";

                //�߸˼�ʧ�ơ��֥���߸˿��������������
                $sql .= "   (SELECT\n";
                $sql .= "       CASE\n";
                $sql .= "           WHEN t_stock.goods_id IS NOT NULL THEN t_stock.goods_id\n";
                $sql .= "           WHEN t_stock.goods_id IS NULL     THEN t_allowance.goods_id\n";
                $sql .= "       END AS goods_id,\n";
                $sql .= "       COALESCE(t_stock.stock_num,0)AS stock_num,\n";
                $sql .= "       COALESCE(t_allowance.allowance_num,0) AS rstock_num\n";
                $sql .= "   FROM\n";
                            //�߸˿���׻�
                $sql .= "       (SELECT\n";
                $sql .= "           goods_id,\n";
                $sql .= "           ware_id,\n";
                $sql .= "           SUM(t_stock_hand.num * \n";
                $sql .= "                   CASE t_stock_hand.io_div\n";
                $sql .= "                       WHEN 1 THEN 1\n";
                $sql .= "                       WHEN 2 THEN -1\n";
                $sql .= "                   END\n";
                $sql .= "           ) AS stock_num,\n";
                $sql .= "           shop_id,\n";
                $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd\n";
                $sql .= "       FROM\n";
                $sql .= "           t_stock_hand\n";
                $sql .= "       WHERE\n";
                $sql .= "           work_div NOT IN (1,3) \n";
                $sql .= "           AND\n";
                $sql .= "           work_day <= '$adjust_date'\n";
                $sql .= "           AND\n";
                $sql .= "           goods_id = $goods_id[$i]\n";
                $sql .= "           AND\n";
                $sql .= "           ware_id = $ware_id\n";
                $sql .= "           AND\n";
                if($_SESSION[group_kind] == '2'){
                    $sql .= "           shop_id IN (".Rank_Sql().")\n";
                }else{  
                    $sql .= "           shop_id = $shop_id\n";
                }       
                $sql .= "       GROUP BY goods_id, ware_id, shop_id\n";
                $sql .= "       ) AS t_stock\n";
                $sql .= "   FULL OUTER JOIN\n";
                                //��������׻�
                $sql .= "       (SELECT\n";
                $sql .= "           goods_id,\n";
                $sql .= "           ware_id,\n";
                $sql .= "           SUM(t_stock_hand.num * \n";
                $sql .= "                   CASE t_stock_hand.io_div\n";
                $sql .= "                       WHEN 1 THEN -1\n";
                $sql .= "                       WHEN 2 THEN 1\n";
                $sql .= "                   END\n";
                $sql .= "           ) AS allowance_num,\n";
                $sql .= "           shop_id,\n";
                $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd\n";
                $sql .= "       FROM\n";
                $sql .= "           t_stock_hand\n";
                $sql .= "       WHERE\n";
                $sql .= "           work_div = '1'\n";
                $sql .= "           AND\n";
                $sql .= "           goods_id = $goods_id[$i]\n";
                $sql .= "           AND\n";
                $sql .= "           work_day <= '$adjust_date'\n";
                $sql .= "           AND\n";
                $sql .= "           ware_id = $ware_id\n";
                $sql .= "           AND\n";
                if($_SESSION[group_kind] == '2'){
                    $sql .= "           shop_id IN (".Rank_Sql().")\n";
                }else{  
                    $sql .= "           shop_id = $shop_id\n";
                }       
                $sql .= "       GROUP BY goods_id, ware_id, shop_id\n";
                $sql .= "       )AS t_allowance\n";
                $sql .= "       ON t_stock.stock_cd = t_allowance.stock_cd\n";
                $sql .= "    )AS t_stock\n";
                $sql .= "    ON t_goods.goods_id = t_stock.goods_id\n";
                #2009-10-12 hashimoto-y
                $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

                $sql .= " WHERE\n";
                $sql .= "    t_goods.goods_id = $goods_id[$i]\n";
                $sql .= "    AND \n";
                #2009-10-12 hashimoto-y
                #$sql .= "    t_goods.stock_manage = '1' \n";
                $sql .= "    t_goods_info.stock_manage = '1' \n";
                $sql .= "    AND \n";
                $sql .= "    t_goods_info.shop_id = $shop_id ";

                $sql .= "    AND \n";
                $sql .= "    t_goods.accept_flg = '1' \n";

                $sql .= "    ORDER BY t_goods.goods_cd\n";
                $sql .= ";\n";

/*
                $sql .= "   (SELECT * FROM t_stock WHERE ware_id = $ware_id) AS t_stock_ware";
                $sql .= "       ON t_goods.goods_id = t_stock_ware.goods_id";
                $sql .= " WHERE";
                $sql .= "   t_goods.goods_id = $goods_id[$i]";
                $sql .= ";";
*/
                $result = Db_Query($conn, $sql);
                $goods_data[$i] = pg_fetch_array($result,0,PGSQL_NUM);
            }
        }
    }

    for($i = 0; $i < $max_row; $i++){        
        for($j = 0; $j < 6; $j++){
            if($goods_data[$i][$j] == null){
                $goods_data[$i][$j] = "";
            }
        }
    
/*
        //()��Ĥ������
        if($goods_data[$i][0] != null && $goods_data[$i][4] != null){
            $goods_data[$i][5] = "(".$goods_data[$i][5].")";
        }elseif($goods_data[$i][0] != null && $goods_data[$i][4] == null){
            $goods_data[$i][4] = "";
            $goods_data[$i][5] = "";
        }
*/

        //���Ϥ���Ƥ���Ĵ�������Ȥˡ���ư��κ߸˿���׻�
        if($_POST['form_io_type'][$i] == 1 && $goods_data[$i][0] != null){
            $a_stock_num[$i] = $goods_data[$i][4] + (int)$_POST["form_adjust_num"][$i];
        }elseif($_POST['form_io_type'][$i] == 2 && $goods_data[$i][0] != null){
            $a_stock_num[$i] = $goods_data[$i][4] - (int)$_POST["form_adjust_num"][$i];
        }else{
            $a_stock_num[$i] = "";
        }
        //�ǡ������å�
        $goods_input_data["form_io_type"][$i]       = $_POST['form_io_type'][$i];
        $goods_input_data["form_goods_id"][$i]      = $goods_data[$i][0];
        $goods_input_data["form_goods_cd"][$i]      = $goods_data[$i][1];
        $goods_input_data["form_goods_name"][$i]    = $goods_data[$i][2];
        $goods_input_data["form_unit"][$i]          = $goods_data[$i][3];
        $goods_input_data["form_b_stock_num"][$i]   = $goods_data[$i][4];
        $goods_input_data["form_b_rstock_num"][$i]  = $goods_data[$i][5];
        $goods_input_data["form_a_stock_num"][$i]   = $a_stock_num[$i];
        $goods_input_data["form_a_rstock_num"][$i]  = $goods_data[$i][5];
        
    }

    $goods_input_data["form_ware_name"]  = $ware_name;
    $goods_input_data["form_ware_id"]    = $ware_id;
    $goods_input_data["show_button_flg"] = "";
    $goods_input_data["hdn_goods_data"]  = "";
    $goods_input_data["hdn_type"]        = $_POST["form_type"];
    $goods_input_data["hdn_adjust_date"] = $adjust_date;
    $form->setConstants($goods_input_data);

}


/****************************/
//���ʥޥ����ξ��ʤ�ɽ���ܥ��󲡲�����
/****************************/
elseif($_POST["mst_button_flg"] != null){

    $ware_id   = $_POST["form_ware"];             //�Ҹ�ID
    $ware_name = "";
    $type      = $_POST["form_type"];             //����


    $adjust_yy = $_POST["form_adjust_day"]["y"];    //ǯ
    $adjust_mm = $_POST["form_adjust_day"]["m"];    //��
    $adjust_dd = $_POST["form_adjust_day"]["d"];    //��

    //�������ϥ����å�
    if($adjust_yy == null || $adjust_mm == null || $adjust_dd == null){
        $adjust_day_err = "Ĵ���������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //����Ⱦ�ѥ����å�
    if(!ereg("^[0-9]+$", $adjust_yy)
        ||
        !ereg("^[0-9]+$", $adjust_mm)
        ||
        !ereg("^[0-9]+$", $adjust_dd)
    ){
        $adjust_day_err = "Ĵ���������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //���������������å�
    if(!checkdate((int)$adjust_mm, (int)$adjust_dd, (int)$adjust_yy)){
        $adjust_day_err = "Ĵ���������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //���������������å�
    if(!checkdate((int)$adjust_mm, (int)$adjust_dd, (int)$adjust_yy)){
        $adjust_day_err = "Ĵ���������դ������ǤϤ���ޤ���";
        $err_flg = true;
     }elseif($err_flg != true){
        $adjust_day_err = Sys_Start_Date_Chk($adjust_yy, $adjust_mm, $adjust_dd, "Ĵ����");
        if($adjust_day_err != null){
            $adjust_day_err = "Ĵ���������դ������ǤϤ���ޤ���";
            $err_flg = true;
        }else{
            $sql = "SELECT MAX(close_day) FROM t_sys_renew WHERE renew_div = '2' AND shop_id = $shop_id;";
            $result = Db_Query($conn, $sql);
            $close_day_last = (pg_fetch_result($result, 0, 0) != null) ? pg_fetch_result($result, 0, 0) : START_DAY;
            $adjust_yy = str_pad($adjust_yy, 4, 0, STR_PAD_LEFT);
            $adjust_mm = str_pad($adjust_mm, 2, 0, STR_PAD_LEFT);
            $adjust_dd = str_pad($adjust_dd, 2, 0, STR_PAD_LEFT);
            if($adjust_yy."-".$adjust_mm."-".$adjust_dd <= $close_day_last){
                $adjust_day_err = "Ĵ���� �ϡ���������ǯ���� ���������դ����Ϥ��Ƥ���������";
                $err_flg = true;
            }
        }
    }

    //���顼�ե饰
    $err_flg = ($ware_id == null || $err_flg == true)? true : false;    //���顼�ե饰��FALSE�ξ��Τ߽�������

    if($err_flg == false){
        //���դ���
        $adjust_date = $adjust_yy."-".$adjust_mm."-".$adjust_dd;

        $sql  = "SELECT";
        $sql .= "   ware_name";
        $sql .= " FROM";
        $sql .= "   t_ware";
        $sql .= " WHERE";
        $sql .= "   ware_id = $ware_id";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $ware_name = pg_fetch_result($result, 0,0);

        $set_goods_data["form_ware_name"] = $ware_name;

        $sql  = "SELECT\n";
        $sql .= "   t_goods.goods_id,\n";
        $sql .= "   t_goods.goods_cd,\n";
        $sql .= "   t_goods.goods_name,\n";
        $sql .= "   t_goods.unit,\n";
        $sql .= "   COALESCE(t_stock.stock_num,0) AS stock_num,\n";
        $sql .= "   COALESCE(t_stock.rstock_num,0) AS rstock_num\n";
        $sql .= " FROM\n";
        $sql .= "   (SELECT\n";
        $sql .= "       t_goods.goods_id,\n";
        $sql .= "       t_goods.goods_cd,\n";
        $sql .= "       t_goods.goods_name,\n";
        $sql .= "       t_goods.unit\n";
        $sql .= "   FROM\n";
        $sql .= "       t_goods\n";
        #2009-10-12 hashimoto-y
        $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
        $sql .= "   WHERE\n";
        //$sql .= "       shop_id = $shop_id\n";
/*
        if($_SESSION[group_kind] == "2"){
            $sql .= "   shop_id IN (".Rank_Sql().") \n";
        }else{
            $sql .= "   shop_id = $_SESSION[client_id]\n";
        }
*/
        #2009-10-12 hashimoto-y
        #$sql .= "       stock_manage = '1'\n";
        $sql .= "        t_goods_info.stock_manage = '1' \n";
        $sql .= "        AND \n";
        $sql .= "        t_goods_info.shop_id = $shop_id ";

        $sql .= "       AND\n";
        $sql .= "       t_goods.accept_flg = '1'\n";
        $sql .= "       AND\n";
        //ľ�Ĥ�����ͭ�����ʤ�ľ�ľ��ʤ��о�
        if($group_kind == "2"){
            if($type == '1'){
                $sql .= "   t_goods.state IN ('1', '3') \n";
            }elseif($type == '2'){
                $sql .= "   t_goods.state = '2' AND shop_id = $shop_id\n";
            }
        //FC������ͭ�����ʤ�FC���ʤ��о�
        }else{
            if($type == '1'){
                $sql .= "   t_goods.state = '1' \n";
            }elseif($type == '2'){
                $sql .= "   t_goods.state = '2' AND t_goods.shop_id = $shop_id \n";
            }else{
                $sql .= "   t_goods.state IN ('1', '2') \n";
            }
        }
        $sql .= "       AND\n";
        $sql .= "       (\n";
        $sql .= "           t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '".$_SESSION["rank_cd"]."')\n";
        $sql .= "           OR\n";
        $sql .= "           t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND\n";
        $sql .= ($group_kind == 2)? "t_goods.shop_id IN (".Rank_Sql().")" : "t_goods.shop_id = $shop_id\n";
        $sql .= "       ))\n";

        $sql .= "   ) AS t_goods\n";
        $sql .= "       LEFT JOIN\n";
        //�߸˼�ʧ�ơ��֥���߸˿��������������
        $sql .= "   (SELECT\n";
        $sql .= "       CASE\n";
        $sql .= "           WHEN t_stock.goods_id IS NOT NULL THEN t_stock.goods_id\n";
        $sql .= "           WHEN t_stock.goods_id IS NULL     THEN t_allowance.goods_id\n";
        $sql .= "       END AS goods_id,\n";
        $sql .= "       COALESCE(t_stock.stock_num,0)AS stock_num,\n";
        $sql .= "       COALESCE(t_allowance.allowance_num,0) AS rstock_num\n";
        $sql .= "   FROM\n";
        //�߸˿���׻�
        $sql .= "       (SELECT\n";
        $sql .= "           goods_id,\n";
        $sql .= "           ware_id,\n";
        $sql .= "           SUM(t_stock_hand.num * \n";
        $sql .= "                   CASE t_stock_hand.io_div\n";
        $sql .= "                       WHEN 1 THEN 1\n";
        $sql .= "                       WHEN 2 THEN -1\n";
        $sql .= "                   END\n";
        $sql .= "           ) AS stock_num,\n";
        $sql .= "           shop_id,\n";
        $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd\n";
        $sql .= "       FROM\n";
        $sql .= "           t_stock_hand\n";
        $sql .= "       WHERE\n";
        $sql .= "           work_div NOT IN (1,3) \n";
        $sql .= "           AND\n";
        $sql .= "           work_day <= '$adjust_date'\n";
        $sql .= "           AND\n";
        $sql .= "           ware_id = $ware_id\n";
        $sql .= "           AND\n";
        if($_SESSION[group_kind] == '2'){
            $sql .= "           shop_id IN (".Rank_Sql().")\n ";
        }else{
            $sql .= "           shop_id = $shop_id\n";
        }
        $sql .= "       GROUP BY goods_id, ware_id, shop_id\n";
        $sql .= "       ) AS t_stock\n";
        $sql .= "   FULL OUTER JOIN\n";
        //��������׻�
        $sql .= "       (SELECT\n";
        $sql .= "           goods_id,\n";
        $sql .= "           ware_id,\n";
        $sql .= "           SUM(t_stock_hand.num * \n";
        $sql .= "                   CASE t_stock_hand.io_div\n";
        $sql .= "                       WHEN 1 THEN -1\n";
        $sql .= "                       WHEN 2 THEN 1\n";
        $sql .= "                   END\n";
        $sql .= "           ) AS allowance_num,\n";
        $sql .= "           shop_id,\n";
        $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd\n";
        $sql .= "       FROM\n";
        $sql .= "           t_stock_hand\n";
        $sql .= "       WHERE\n";
        $sql .= "           work_div = '1'\n";
        $sql .= "           AND\n";
        $sql .= "           work_day <= '$adjust_date'\n";
        $sql .= "           AND\n";
        $sql .= "           ware_id = $ware_id\n";
        $sql .= "           AND\n";
        if($_SESSION[group_kind] == '2'){
            $sql .= "           shop_id IN (".Rank_Sql().")\n";
        }else{
            $sql .= "           shop_id = $shop_id\n";
        }
        $sql .= "       GROUP BY goods_id, ware_id, shop_id\n";
        $sql .= "       )AS t_allowance\n";
        $sql .= "       ON t_stock.stock_cd = t_allowance.stock_cd\n";
        $sql .= "    )AS t_stock\n";
        $sql .= "    ON t_goods.goods_id = t_stock.goods_id\n";
        $sql .= "    ORDER BY t_goods.goods_cd\n";
        $sql .= ";\n";

/*
        $sql .= "   (SELECT\n";
        $sql .= "       goods_id,\n";
        $sql .= "       stock_num,\n";
        $sql .= "       rstock_num\n";
        $sql .= "   FROM\n";
        $sql .= "       t_stock\n";
        $sql .= "   WHERE\n";
        //$sql .= "   t_stock.shop_id = $shop_id\n";
        if($_SESSION[group_kind] == "2"){
            $sql .= "   t_stock.shop_id IN (".Rank_Sql().") ";
        }else{
            $sql .= "   t_stock.shop_id = $_SESSION[client_id]";
        }
        $sql .= "   AND\n";
        $sql .= "   t_stock.ware_id = $ware_id\n";
        $sql .= "   ) AS t_stock\n";
        $sql .= "   ON t_goods.goods_id = t_stock.goods_id\n";
        $sql .= "   ORDER BY t_goods.goods_cd\n";
        $sql .= ";\n";

*/
        $result = Db_Query($conn, $sql);
        $mst_goods_num = pg_num_rows($result);

        //��Ф�������ʬ�롼��
        for($i = 0; $i < $mst_goods_num; $i++){
            $mst_goods_data = pg_fetch_array($result, $i);

            $set_goods_data["form_io_type"][$i]      = 1;
            $set_goods_data["form_goods_id"][$i]     = $mst_goods_data["goods_id"];
            $set_goods_data["form_goods_cd"][$i]     = $mst_goods_data["goods_cd"];
            $set_goods_data["form_goods_name"][$i]   = $mst_goods_data["goods_name"];
            $set_goods_data["form_unit"][$i]         = $mst_goods_data["unit"];
//            $set_goods_data["form_adjust_num"][$i]   = "0";
            $set_goods_data["form_adjust_num"][$i]   = "";
            $set_goods_data["form_b_stock_num"][$i]  = $mst_goods_data["stock_num"];
            $set_goods_data["form_b_rstock_num"][$i] = $mst_goods_data["rstock_num"];
            $set_goods_data["form_a_stock_num"][$i]  = $mst_goods_data["stock_num"];
            $set_goods_data["form_a_rstock_num"][$i] = $mst_goods_data["rstock_num"];
            //�ޥ����������ʤ�ɽ���ܥ��󤬲����줿��硢
            //Ĵ����ͳ�ˡ֥����ƥ೫�Ϻ߸ˡפ�����
            $set_goods_data["form_adjust_reason"][$i] = "1";

        }

        $set_goods_data["form_ware_id"] = $ware_id;


        $set_goods_data["hdn_type"] = $type;
        $set_goods_data["hdn_adjust_date"] = $adjust_date;

        $max_row = ($mst_goods_num > 5)? $mst_goods_num : 5;
    }
    $set_goods_data["mst_button_flg"] = "";
    $form->setConstants($set_goods_data);
}


/****************************/
//���ʥ��������Ͻ���
/****************************/
elseif($_POST["input_row_num"] != null){ 

    //���Ϲ�
    $input_num = $_POST["input_row_num"];

    //�Ҹ�ID�����
    $ware_id = $_POST["form_ware_id"];
    $ware_name = $_POST["form_ware_name"];

    $type  = $_POST["form_type"];           //����

    $adjust_date = $_POST["hdn_adjust_date"];

    //�ͥ����å�
    if(strlen($_POST["form_goods_cd"][$input_num])==8 
        &&
        is_numeric($_POST["form_goods_cd"][$input_num])
        &&
        $ware_id != null
        ){

        $goods_cd = $_POST["form_goods_cd"]["$input_num"];

        $sql  = "SELECT\n";
        $sql .= "   t_goods.goods_id,\n";
        $sql .= "   t_goods.goods_cd,\n";
        $sql .= "   t_goods.goods_name,\n";
        $sql .= "   t_goods.unit,\n";
        $sql .= "   COALESCE(t_stock.stock_num,0),\n";
        $sql .= "   COALESCE(t_stock.rstock_num,0)\n";
        $sql .= " FROM\n";
        $sql .= "   (SELECT\n ";
        $sql .= "       t_goods.goods_id,\n";
        $sql .= "       t_goods.goods_cd,\n";
        $sql .= "       t_goods.goods_name,\n";
        $sql .= "       t_goods.unit\n";
        $sql .= "   FROM\n";
        $sql .= "       t_goods\n";
        $sql .= "           INNER JOIN\n";
        $sql .= "       t_goods_info\n";
        $sql .= "       ON t_goods.goods_id = t_goods_info.goods_id\n";
        #2009-10-12 hashimoto-y
        #$sql .= "       INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

        $sql .= "   WHERE\n";
        #2009-10-12 hashimoto-y
        #$sql .= "       t_goods.stock_manage = '1'\n";
        $sql .= "    t_goods_info.stock_manage = '1' \n";
        $sql .= "    AND \n";
        $sql .= "    t_goods_info.shop_id = $shop_id ";

        $sql .= "       AND\n";
//        $sql .= "       shop_gid = $shop_gid";
/*
        if($_SESSION[group_kind] == '2'){
            $sql .= "           t_goods_info.shop_id IN (".Rank_Sql().")\n ";
        }else{
            $sql .= "           t_goods_info.shop_id = $shop_id\n";
        }
*/
        $sql .= "       (\n";
        $sql .= "           t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '".$_SESSION["rank_cd"]."')\n";
        $sql .= "           OR\n";
        $sql .= "           t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND\n";
        $sql .= ($group_kind == 2)? "shop_id IN (".Rank_Sql().")" : "shop_id = $shop_id\n";
        $sql .= "       ))\n";
        $sql .= "       AND\n";
        $sql .= "       t_goods.goods_cd = '$goods_cd'\n";
        $sql .= "       AND\n";
        #2009-10-12 hashimoto-y
        #Ʊ��SQL��Ʊ�����򣲲�ƤӽФ��Ƥ���
        #$sql .= "       t_goods.stock_manage = '1'\n";
        #$sql .= "       AND\n";

        $sql .= "       t_goods.accept_flg = '1'\n";
        //ľ�Ĥ�����ͭ�����ʤ�ľ�ľ��ʤ��о�
        if($group_kind == "2"){
            if($type == "1"){
                $sql .= "       AND \n";
                $sql .= "       t_goods.state IN ('1', '3') \n";
            }elseif($type == "2"){
                $sql .= "       AND \n";
                $sql .= "       t_goods.state = '2' \n";
            }
        //FC������ͭ�����ʤ�FC���ʤ��о�
        }else{
            $sql .= "       AND \n";
            if($type == "1"){
                $sql .= "       t_goods.state = '1' \n";
            }elseif($type == "2"){
                $sql .= "       t_goods.state = '2' AND t_goods.shop_id = $shop_id\n";
            }else{
                $sql .= "       t_goods.state IN ('1', '2') \n";
            }
        }
        $sql .= "   ) AS t_goods\n";
        $sql .= "       LEFT JOIN\n";
                    //�߸˼�ʧ�ơ��֥���߸˿��������������
        $sql .= "   (SELECT\n";
        $sql .= "       CASE\n";
        $sql .= "           WHEN t_stock.goods_id IS NOT NULL THEN t_stock.goods_id\n";
        $sql .= "           WHEN t_stock.goods_id IS NULL     THEN t_allowance.goods_id\n";
        $sql .= "       END AS goods_id,\n";
        $sql .= "       COALESCE(t_stock.stock_num,0)AS stock_num,\n";
        $sql .= "       COALESCE(t_allowance.allowance_num,0) AS rstock_num\n";
        $sql .= "   FROM\n";
                        //�߸˿���׻�
        $sql .= "       (SELECT\n";
        $sql .= "           goods_id,\n";
        $sql .= "           ware_id,\n";
        $sql .= "           SUM(t_stock_hand.num * \n";
        $sql .= "                   CASE t_stock_hand.io_div\n";
        $sql .= "                       WHEN 1 THEN 1\n";
        $sql .= "                       WHEN 2 THEN -1\n";
        $sql .= "                   END\n";
        $sql .= "           ) AS stock_num,\n";
        $sql .= "           shop_id,\n";
        $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd\n";
        $sql .= "       FROM\n";
        $sql .= "           t_stock_hand\n";
        $sql .= "       WHERE\n";
        $sql .= "           work_div NOT IN (1,3) \n";
        $sql .= "           AND\n";
        $sql .= "           work_day <= '$adjust_date'\n";
        $sql .= "           AND\n";
        $sql .= "           ware_id = $ware_id\n";
        $sql .= "           AND\n";
        if($_SESSION[group_kind] == '2'){
            $sql .= "           shop_id IN (".Rank_Sql().")\n ";
        }else{
            $sql .= "           shop_id = $shop_id\n";
        }
        $sql .= "       GROUP BY goods_id, ware_id, shop_id\n";
        $sql .= "       ) AS t_stock\n";
        $sql .= "   FULL OUTER JOIN\n";
                        //��������׻�
        $sql .= "       (SELECT\n";
        $sql .= "           goods_id,\n";
        $sql .= "           ware_id,\n";
        $sql .= "           SUM(t_stock_hand.num * \n";
        $sql .= "                   CASE t_stock_hand.io_div\n";
        $sql .= "                       WHEN 1 THEN -1\n";
        $sql .= "                       WHEN 2 THEN 1\n";
        $sql .= "                   END\n";
        $sql .= "           ) AS allowance_num,\n";
        $sql .= "           shop_id,\n";
        $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd\n";
        $sql .= "       FROM\n";
        $sql .= "           t_stock_hand\n";
        $sql .= "       WHERE\n";
        $sql .= "           work_div = '1'\n";
        $sql .= "           AND\n";
        $sql .= "           work_day <= '$adjust_date'\n";
        $sql .= "           AND\n";
        $sql .= "           ware_id = $ware_id\n";
        $sql .= "           AND\n";
        if($_SESSION[group_kind] == '2'){
            $sql .= "           shop_id IN (".Rank_Sql().")\n ";
        }else{
            $sql .= "           shop_id = $shop_id\n";
        }
        $sql .= "       GROUP BY goods_id, ware_id, shop_id\n";
        $sql .= "       )AS t_allowance\n";
        $sql .= "       ON t_stock.stock_cd = t_allowance.stock_cd\n";
        $sql .= "    )AS t_stock\n";
        $sql .= "    ON t_goods.goods_id = t_stock.goods_id\n";
/*
        $sql .= "       LEFT JOIN";
        $sql .= "   (SELECT ";
        $sql .= "       *";
        $sql .= "   FROM";
        $sql .= "       t_stock";
        $sql .= "   WHERE";
        $sql .= "       ware_id = $ware_id";
        $sql .= "       AND";
        $sql .= "       shop_id = $shop_id";
        $sql .= "   ) AS t_stock_2";
        $sql .= "       ON t_stock_goods.goods_id = t_stock_2.goods_id";
*/ 
        $sql .= ";";
//print_array($sql);

        $result = Db_Query($conn, $sql);
        $num = pg_num_rows($result);

        //��������쥳���ɤ����ä����
        if($num > 0){
            $goods_data[] = pg_fetch_array($result, 0, PGSQL_NUM); 

            //�߸˿��ơ��֥����Ͽ�Τʤ����ϡ�""������
            if($goods_data[0][4] == null && $goods_data[0][5] == null){
                $goods_data[0][4] = "";
                $goods_data[0][5] = "";
            }

            if($goods_data[0][4] != null){
                $goods_data[0][5] = $goods_data[0][5];
            }elseif($goods_data[0][4] == null){
                $goods_data[0][4] = "";
                $goods_data[0][5] = "";
            }

            //���Ϥ���Ƥ���Ĵ�������Ȥˡ���ư��κ߸˿���׻�
            if($_POST['form_io_type'][$input_num] == 1 && $goods_data[0][0] != null 
                && $_POST["form_adjust_num"][$i] != null && $_goods_data[0][4]){
                $a_stock_num = $goods_data[0][4] + $_POST["form_adjust_num"][$input_num];
            }elseif($_POST["form_io_type"][$input_num] == 2 && $goods_data[0][0] != null 
                && $_POST["form_adjust_num"][$i] != null){
                $a_stock_num = $goods_data[0][4] - $_POST["form_adjust_num"][$input_num];
            }
    
            //�ǡ������å�
            $goods_input_data["form_io_type"][$input_num]       = $_POST['form_output_type'][$input_num];
            $goods_input_data["form_goods_id"][$input_num]      = $goods_data[0][0];
            $goods_input_data["form_goods_cd"][$input_num]      = $goods_data[0][1];
            $goods_input_data["form_goods_name"][$input_num]    = $goods_data[0][2];
            $goods_input_data["form_unit"][$input_num]          = $goods_data[0][3];
            $goods_input_data["form_b_stock_num"][$input_num]   = $goods_data[0][4];
            $goods_input_data["form_b_rstock_num"][$input_num]  = $goods_data[0][5];
            //$goods_input_data["form_a_stock_num"][$input_num]   = $a_stock_num;
            $goods_input_data["form_a_stock_num"][$input_num]   = $goods_data[0][4];
            $goods_input_data["form_a_rstock_num"][$input_num]  = $goods_data[0][5];
        }else{
            //�ǡ������å�
            $goods_input_data["form_io_type"][$input_num]           = $_POST['form_io_type'][$input_num];
            $goods_input_data["form_goods_id"][$input_num]          = "";
            $goods_input_data["form_goods_cd"][$input_num]          = "";
            $goods_input_data["form_goods_name"][$input_num]        = "";
            $goods_input_data["form_b_stock_num"][$input_num]       = "";
            $goods_input_data["form_b_rstock_num"][$input_num]      = "";
            $goods_input_data["form_adjust_num"][$input_num]        = $_POST["form_adjust_num"][$input_num];
            $goods_input_data["form_unit"][$input_num]              = "";
            $goods_input_data["form_a_stock_num"][$input_num]       = "";
            $goods_input_data["form_a_rstock_num"][$input_num]      = "";        
        }
    }else{
        //�ǡ������å�
        $goods_input_data["form_io_type"][$input_num]           = $_POST['form_io_type'][$input_num];
        $goods_input_data["form_goods_id"][$input_num]          = "";
        $goods_input_data["form_goods_cd"][$input_num]          = $_POST['form_goods_cd'][$input_num];
        $goods_input_data["form_goods_name"][$input_num]        = "";
        $goods_input_data["form_b_stock_num"][$input_num]       = "";
        $goods_input_data["form_b_rstock_num"][$input_num]      = "";
        $goods_input_data["form_adjust_num"][$input_num]        = $_POST["form_adjust_num"][$input_num];
        $goods_input_data["form_unit"][$input_num]              = "";
        $goods_input_data["form_a_stock_num"][$input_num]       = "";
        $goods_input_data["form_a_rstock_num"][$input_num]      = "";        
 
    }
    $goods_input_data["form_type"] = $_POST["hdn_type"];
    //input_row_num�򥯥ꥢ
    $goods_input_data["input_row_num"]="";
    $adjust_day = explode("-", $_POST["hdn_adjust_date"]);
    $goods_input_data["form_adjust_day"]["y"] = $adjust_day[0];
    $goods_input_data["form_adjust_day"]["m"] = $adjust_day[1];
    $goods_input_data["form_adjust_day"]["d"] = $adjust_day[2];
    $form->setConstants($goods_input_data);
}

/****************************/
//��ȿž��󥯲�������
/****************************/
elseif($_POST["change_flg"] == true){

    //2006-07-11 kaji
    $ware_id = $_POST["form_ware_id"];
/*
    $del_row = $_POST["del_row"];
    $del_history = explode(",", $del_row);
*/
    for($i = 0; $i < $max_row; ++$i){

        //�����Ƚ��
//        if(!in_array("$i", $del_history)){
            
            //POST����
            $change_io_type[$i]      = $_POST["form_io_type"][$i];
            $change_b_stock_num[$i]  = $_POST["form_b_stock_num"][$i];
            $change_adjust_num[$i]   = $_POST["form_adjust_num"][$i];

            //ȿž����
            if($change_io_type[$i] == "1"){
                $change_io_type[$i] = "2";
                if($change_b_stock_num[$i] != ""){
                    $change_a_stock_num[$i] = $change_b_stock_num[$i] - $change_adjust_num[$i];
                }
            }else{
                $change_io_type[$i] = "1";
                if($change_b_stock_num[$i] != ""){
                        $change_a_stock_num[$i] = $change_b_stock_num[$i] + $change_adjust_num[$i];
                    }
            }

            //�ǡ������å�
            $change_data["form_io_type"][$i]        = $change_io_type[$i];
            $change_data["form_a_stock_num"][$i]    = $change_a_stock_num[$i];
//        }
    }

    //�ե饰�򥯥ꥢ
    $change_data["change_flg"] = "";
    $adjust_day = explode("-", $_POST["hdn_adjust_date"]);
    $change_data["form_adjust_day"]["y"] = $adjust_day[0];
    $change_data["form_adjust_day"]["m"] = $adjust_day[1];
    $change_data["form_adjust_day"]["d"] = $adjust_day[2];
    $form->setConstants($change_data);
}

/****************************/
//�Կ��ɲ�
/****************************/
elseif($_POST["add_row_flg"]==true){

    //����Ԥˡ��ܣ�����
    $max_row = $_POST["max_row"]+1;

    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);

}

/****************************/
//�Ժ������
/****************************/
/*
if(isset($_POST["del_row"])){

    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];

    //������������ˤ��롣
    $del_history = explode(",", $del_row);
}

/***************************/
//���������
/***************************/
for($i = 0; $i < $max_row; $i++){
    $def_fdata["form_io_type"][$i] = "1";
}
$def_fdata["form_type"] = "1";
$form->setDefaults($def_fdata);

//�Կ�set
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);

/****************************/
//�ե��������(�����)
/****************************/
//text
//�о��Ҹ�
$select_value = Select_Get($conn,'ware');
$form->addElement('select', 'form_ware', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//radio
//����
$radio[] = $form->createElement("radio", null, null, "ͭ��", "1");
$radio[] = $form->createElement("radio", null, null, "̵��", "2");
$radio[] = $form->createElement("radio", null, null, "����", "3");
$form->addGroup($radio, "form_type", "");


//button
$form->addElement("button","form_all_select_button","�Ҹ���������ʤ�ɽ��","
        onClick=\"javascript:Button_Submit('allgoods_button_flg','#', 'true')\"");
$form->addElement("button", "form_show_button","ɽ����","
        onClick=\"javascript:Button_Submit('show_button_flg','#', 'true')\"");
//$form->addElement("button","form_adjust_button","�¡���","
//        onClick=\"javascript:Dialogue_2('�߸ˤ�Ĵ�����ޤ���','#', 'true', 'adjust_button_flg')\" $disabled");
$form->addElement(
    "submit", "form_adjust_button", "�¡���", "onClick=\"javascript:return Dialogue('�߸ˤ�Ĵ�����ޤ���','#', this)\" $disabled");

$form->addElement("button","change_button","�졡��","
		onClick=\"location.href='2-4-111.php'\"");
$form->addElement("button","new_button","������",
		$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","mst_goods_button","�߸˾��ʤ�ɽ��","
        onClick=\"javasclipt:Button_Submit('mst_button_flg', '#', 'true')\"");
$form->addElement("button","add_row_button","���ɲ�","onClick=\"javascript:Button_Submit_1('add_row_flg', '#', 'true')\"");

//hidden
$form->addElement("hidden", "form_ware_name");
$form->addElement("hidden", "form_ware_id");
//$form->addElement("hidden", "form_ware_name");
//$form->addElement("hidden", "del_row");             //�����
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰
$form->addElement("hidden", "input_row_num");       //���ʥ��������Ϲ�
$form->addElement("hidden", "max_row");             //����Կ�
$form->addElement("hidden", "allgoods_button_flg"); //���ʤ�����ɽ���ܥ���
$form->addElement("hidden", "show_button_flg");     //ɽ���ܥ���
$form->addElement("hidden", "change_flg");          //��ȿž���
//$form->addElement("hidden", "adjust_button_flg");   //Ĵ���ܥ���
$form->addElement("hidden", "mst_button_flg");      //�ޥ�������ɽ���ܥ���ե饰
$form->addElement("hidden", "hdn_type");            //
$form->addElement("hidden", "hdn_adjust_date");     //Ĵ����

//Ĵ����
$form_adjust_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form,'form_adjust_day[y]','form_adjust_day[m]',4)\"
    onFocus=\"onForm_today(this,this.form,'form_adjust_day[y]','form_adjust_day[m]','form_adjust_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_adjust_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\"
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form, 'form_adjust_day[m]','form_adjust_day[d]',2)\"
    onFocus=\"onForm_today(this,this.form,'form_adjust_day[y]','form_adjust_day[m]','form_adjust_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_adjust_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\"
    style=\"$g_form_style \"
    onFocus=\"onForm_today(this,this.form,'form_adjust_day[y]','form_adjust_day[m]','form_adjust_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_adjust_day,"form_adjust_day","","-");

/***************************/
//�ե������������ư��
/***************************/
//���ֹ楫����
$row_num = 1;

for($i = 0; $i < $max_row; ++$i){

    //�����Ƚ��
//    if(!in_array("$i", $del_history)){

        //�������
//        $del_data = $del_row.",".$i;

        //�饸���ܥ���
        $form_io_type[$i][] =& $form->createElement(
                "radio",NULL,
                NULL, "����","1",
                "onClick=\"sum('$i')\"
                ");
        $form_io_type[$i][] =& $form->createElement( "radio", NULL,
                NULL, "�и�","2",
                "onClick=\"sum('$i')\"
                ");
        $form->addGroup
                ( $form_io_type[$i], "form_io_type[$i]", "���ж�ʬ"); 

        //����
        $form->addElement("hidden", "form_goods_id[$i]");            //����ID
        $form->addElement(
                "text", 
                "form_goods_cd[$i]", "", 
                "value=\"\" size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
                onFocus=\"onForm(this)\" 
                onBlur=\"blurForm(this)\"
                onChange=\"goods_search_1(this.form, 'form_goods_cd', 'input_row_num', '$i')\""
                );
        $form->addElement(
                'text',
                 "form_goods_name[$i]", '',
                " size=\"54\" 
                $g_text_readonly"
                );
        $form->addElement(
                'text', "form_b_stock_num[$i]", '',
                "value=\"\" 
                style=\"color : #000000; border : #ffffff 1px 
                solid; background-color: #ffffff; text-align: right\" 
                readonly"
                );
        $form->addElement(
                'text', "form_b_rstock_num[$i]", '',
                'value="" size="10" 
                style="color : #0000ff; border : #ffffff 1px 
                solid; background-color: #ffffff; text-align: right" 
                readonly'
                );
        $form->addElement(
                'text', "form_adjust_num[$i]", '', 
                "value=\"\" size=\"11\" maxLength=\"9\" 
                onFocus=\"onForm(this)\" 
                onChange=\"sum('$i')\"
                onBlur=\"blurForm(this)\" 
                style=\"text-align: right;$g_form_style\""
                );
        $form->addElement('text', "form_unit[$i]", '',
                'value="" size="10" 
                style="color : #000000; border : #ffffff 1px 
                solid; background-color: #ffffff; text-align: left" 
                readonly'
                );
        $form->addElement(
                'text', "form_a_stock_num[$i]", '',
                'value="" 
                style="color : #000000; border : #ffffff 1px 
                solid; background-color: #ffffff; text-align: right" 
                readonly'
                );
        $form->addElement(
                'text', "form_a_rstock_num[$i]", '',
                'value="" size="10" 
                style="color : #0000ff; border : #ffffff 1px 
                solid; background-color: #ffffff; 
                text-align: right" readonly'
                );
        //Ĵ����ͳ
/*
        $form->addElement(
                'text', "form_adjust_reason[$i]", '', 
                "value=\"\" size=\"22\" maxLength=\"15\" 
                onFocus=\"onForm(this)\" 
                onBlur=\"blurForm(this)\""
                );
*/
        $select_adjust_reason_value = array(
            "0" => "",
            "4" => "ȯ��",
            "2" => "��»",
            "3" => "ʶ��",
            "5" => "�߸˵����ߥ�",
            "1" => "�����ƥ೫�Ϻ߸�",
            "6" => "���֥����¤",
        );
        $form->addElement(
            "select", "form_adjust_reason[$i]", "", $select_adjust_reason_value,
            "$g_form_option_select"
            );


        if($ware_id != null){

        /****************************/
        //ɽ����HTML����
        /****************************/
        $html .= "<tr class=\"Result1\">";
        $html .=    "<td align=\"right\">$row_num</td>";

        //�饸���ܥ���
        $html .=    "<td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_io_type[$i]"]]->toHtml();
        $html .=    "</td>\n";

        //���ʥ����ɡ�����̾
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();

        //�Ҹˤ����򤵤줿���
        $html .=        "��<a href=\"#\" onClick=\"return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd[".$i."]','input_row_num'),500,450,1,'$ware_id','$i');\">����</a>��";
        $html .=        "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>\n";

        //���߸Ŀ��ʰ�������Ĵ����
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_b_stock_num[$i]"]]->toHtml();
        $html .=        "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_b_rstock_num[$i]"]]->toHtml();
        $html .=    "</td>\n";

        //Ĵ����
        $html .=    "<td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_adjust_num[$i]"]]->toHtml();
        $html .=    "</td>\n";

        //ñ��
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_unit[$i]"]]->toHtml();
        $html .=    "</td>\n";

        //���߸Ŀ��ʰ�������Ĵ����
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_a_stock_num[$i]"]]->toHtml();
        $html .=        "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_a_rstock_num[$i]"]]->toHtml();
        $html .=    "</td>";

        //Ĵ����ͳ
        $html .=    "<td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_adjust_reason[$i]"]]->toHtml();
        $html .=    "</td>\n";
/*
        //������
        $html .=    "<td align=\"center\">";
        $html .=       "<a href=\"#\" onClick=\"javascript:Dialogue_1('������ޤ���', '$del_data', 'del_row')\">���</a>";
        $html .=    "</td>\n";
*/
        //��λ�ܥ�������Ӥޤ����
        $html .=    "<td align=\"center\">";
        $html .=       "<a href=\"#form_adjust_button\">Ĵ���»�<br>�ܥ����</a>";
        $html .=    "</td>\n";

        $html .= "</tr>";

        //���ֹ��ܣ�
        $row_num = $row_num+1;
//    }
    }
}

/***************************/
//�롼�����
/***************************/
$form->addRule("form_ware", "�Ҹˤ�ɬ�ܹ��ܤǤ���", "required");

/***************************/
//Ĵ���ܥ��󲡲�����
/***************************/
//if($_POST["adjust_button_flg"] == "true" ){
if($_POST["form_adjust_button"] == "�¡���" ){

    /***************************/
    //POST�������
    /***************************/
    $ware_id     = $_POST["form_ware_id"];
    $adjust_date = $_POST["hdn_adjust_date"];

    //�ѿ������
    unset($io_type);
    unset($goods_id);
    unset($goods_cd);
    unset($goods_name);
    unset($adjust_num);
    unset($adjust_reason);

    for($i=0; $i < $max_row; $i++){
        if($_POST["form_goods_id"][$i] != ""){
            $io_type[]       = $_POST["form_io_type"][$i];                  //�饸���ܥ���
            $goods_id[]      = $_POST["form_goods_id"][$i];                 //���ʥ�����
            $goods_cd[]      = $_POST["form_goods_cd"][$i];
            $goods_name[]    = $_POST["form_goods_name"][$i];
            $adjust_num[]    = $_POST["form_adjust_num"][$i];              //Ĵ����
            $adjust_reason[] = $_POST["form_adjust_reason"][$i];          //Ĵ����ͳ
        }
    }

    /***************************/
    //�롼�������PHP��
    /***************************/
    //���ʤ����Ϥ���Ƥ������
    if($input_num != null){
        $goods_input_err = "���ʾ���������ˡ��¡��ܥܥ��󤬲�����ޤ�����<br>���ٽ�������ľ���Ƥ���������";
        $err_flg = true;
    }

    $form->addRule("form_ware", "�Ҹˤ�ɬ�ܹ��ܤǤ���","required");

    for($i = 0; $i < $max_row; $i++){
        //�����ʥ�����
        //��ɬ�ܥ����å�
        if($goods_cd[$i] != null && $goods_name[$i] != null){
            $goods_input_flg = true;
        }

        if($goods_cd[$i] != null && $goods_name[$i] == null){
            $goods_err = "���������ʥ����ɤ����Ϥ��Ʋ�������";
            $err_flg = true;
        }

        //��Ĵ����
        //��ɬ�ܥ����å�
/*
        if($goods_id[$i] != null && $adjust_num[$i] == null){
            $adjust_num_err = "Ĵ������Ⱦ�ѿ���1ʸ���ʾ�9ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }elseif($goods_id[$i] != null && $adjust_num[$i] != null){
            $input_flg[$i] = true;
        }
*/

//        if($input_flg[$i] == true && !ereg("^[0-9]+$", $adjust_num[$i])){
        if(!ereg("^[0-9]+$", $adjust_num[$i]) && $adjust_num[$i] != null){
            $adjust_num_err = "Ĵ������Ⱦ�ѿ���1ʸ���ʾ�9ʸ���ʲ��Ǥ���";
            $err_flg = true; 
        }

        //��Ʊ�쾦�ʤ�ʣ�����򤵤�Ƥ�����
        for($j = 0; $j < $max_row; $j++){
            if($input_flg[$i] == true && $i != $j && $goods_id[$i] == $goods_id[$j]){
                $goods_err = "���ʤ�Ʊ�����ʤ�2��ʾ����򤵤�Ƥ��ޤ���";
                $err_flg = true;
            }
        }

        //Ĵ����ͳ
        //��ɬ�ܥ����å�
        if($goods_id[$i] != null && $adjust_reason[$i] == "0"){
            $adjust_reason_err = "Ĵ����ͳ��ɬ�ܹ��ܤǤ���";
            $err_flg = true;
        }

    }
    if($goods_input_flg != true){
        $goods_err = "���ʤ���Ĥ����򤵤�Ƥ��ޤ���";
        $err_flg = true;
    }

    /***************************/
    //��Ͽ����
    /*****************************/
    if($form->validate() && $err_flg != true){
        Db_Query($conn, "BEGIN");

/*
        //���߸Ŀ�������������Ф��ʤ�����
        for($i = 0; $i < count($goods_id); $i++){
            $insert_sql  = "SELECT";
            $insert_sql .= "    stock_num,";
            $insert_sql .= "    rstock_num";
            $insert_sql .= " FROM";
            $insert_sql .= "    t_stock";
            $insert_sql .= " WHERE";
            $insert_sql .= "    t_stock.goods_id = $goods_id[$i]";
            $insert_sql .= "    AND";
            $insert_sql .= "    ware_id = $ware_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            $res_num[$i] = pg_num_rows($result);
        
            //�߸˿��ơ��֥�˥쥳���ɤ����롣
            if($res_num[$i] > 0){
                $db_stock_num  = pg_fetch_result($result,0,0);
                $rstock_num[$i] = pg_fetch_result($result,0,1);
 
                if($io_type[$i] == 1){
                    $stock_num[$i] = (int)$adjust_num[$i] + $db_stock_num;
                }elseif($io_type[$i] == 2){
                    $stock_num[$i] = $db_stock_num - (int)$adjust_num[$i];
                }
            //�߸˿��ơ��֥�˥쥳���ɤ��ʤ���
            }else{
                $rstock_num[$i] = 0;
            
                if($io_type[$i] == 1){
                    $stock_num[$i] = (int)$adjust_num[$i];
                }elseif($io_type[$i] == 2){
                    $stock_num[$i] = - (int)$adjust_num[$i];
                }
            }
        }
*/
        //�߸˼�ʧ�ơ��֥�
        for($i = 0; $i < count($goods_id); $i++){
            if($adjust_num[$i] != null && $adjust_num[$i] != 0){
                $insert_sql  = " INSERT INTO t_stock_hand (";
                $insert_sql .= "    goods_id,";
                $insert_sql .= "    work_day,";
                $insert_sql .= "    work_div,";
                $insert_sql .= "    ware_id,";
                $insert_sql .= "    io_div,";
                $insert_sql .= "    num,";
                $insert_sql .= "    adjust_price,";
                $insert_sql .= "    staff_id,";
                $insert_sql .= "    shop_id,";
                $insert_sql .= "    adjust_reason";
                $insert_sql .= " )VALUES(";
                $insert_sql .= "    $goods_id[$i],";
                $insert_sql .= "    '$adjust_date',";
                $insert_sql .= "    '6',";
                $insert_sql .= "    $ware_id,";
                $insert_sql .= "    $io_type[$i],";
                $insert_sql .= "    $adjust_num[$i],";
                $insert_sql .= "    (SELECT";
                $insert_sql .= "        r_price";
                $insert_sql .= "    FROM";
                $insert_sql .= "        t_price";
                $insert_sql .= "    WHERE";
                $insert_sql .= "        goods_id = $goods_id[$i]";
                $insert_sql .= "        AND";
                //$insert_sql .= "        rank_cd = '1'";
                $insert_sql .= "        rank_cd = '3'";     //FC��ǽ�ǤϺ߸�ñ��
                $insert_sql .= "        AND";
                //$insert_sql .= "        shop_id = $shop_id";
                $insert_sql .= ($group_kind == "2") ? "        shop_id IN (".Rank_Sql().") \n" : "        shop_id = $shop_id \n";
//            $insert_sql .= "        shop_gid = $shop_gid";
                $insert_sql .= "    ),";
                $insert_sql .= "    $staff_id,";
                $insert_sql .= "    $shop_id,";
                $insert_sql .= "    '".$adjust_reason[$i]."'";
                $insert_sql .= ");";

                $result = Db_Query($conn, $insert_sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK");
                    exit;
                }
            }
        }
        Db_Query($conn,"COMMIT");
        //header("Location: $_SERVER[PHP_SELF]");
        header("Location: 2-4-108-2.php?done_flg=true");
    }
    $def_data["adjust_button_flg"] = "";
    $form->setConstants($def_data);
}

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
        'max_row'       => "$max_row",
        'validate_flg'  => "$validate_flg",
        'post_flg'      => "$post_flg",
        'ware_name'     => stripslashes(htmlspecialchars($ware_name)),
        'goods_err'     => "$goods_err",
        'adjust_num_err'    => "$adjust_num_err",
        'adjust_reason_err' => "$adjust_reason_err",
        'adjust_date_err' => "$adjust_day_err",
        'goods_input_err' => "$goods_input_err",
));

$smarty->assign("html", $html);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>

