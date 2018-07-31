<?php
/**
 *
 * ê����������
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
 * ����
 * ��ê���������˺߸˿���Ĵ������
 *   �ʺ߸�Ĵ���μ�ʧ����Ͽ��
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.8 (2006/10/17)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/07      02-013      kajioka-h   �����оݤ�ê��Ĵ��ɽ��¸�ߤ��ʤ����˥�å�������ɽ��
 *  2007/01/22      xx-xxx      kajioka-h   ê���������Ͽ����ä����˥��顼��å�������ɽ��
 *  2007/01/30      0069        kajioka-h   ê��������λ������ܤ�����̤��ְ�äƤ���Х�����
 *  2007/05/04      ����¾119   kajioka-h   ê�����ۤ��ʧ����Ͽ
 *  2007/05/14      ����¾92    kajioka-h   ê�����Ϥ�50�Ԥ��Ȥ�ɽ������Ͽ��ǽ�ˤ������ᡢ�����Ͽ��Ƚ����ѹ�
 *  2007/05/18      xx-xxx      kajioka-h   ê�����Ϥκ��۸����ˡ�Ĵ���פ��ɲä������ᡢ��ʧ����Ͽ����Ĵ����ͳ�ˤ��ɲ�
 */

$page_title = "ê����������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB��³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//SESSION����
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

//��λ�������URL
$pre_url = ($group_kind == "1") ? "./1-5-104.php" : "./2-5-104.php";

//��λ�ե饰
$complete_msg = ($_GET["done"] == "t") ? "ê��������λ���ޤ�����" : null;

//�ե��������
$form->addElement("button","jikkou","�¡���","onClick=\"javascript:Dialogue_1('�¹Ԥ��ޤ���','true','jikkou_button_flg')\" $disabled");

//hidden
$form->addElement("hidden","jikkou_button_flg");

//���󹹿����ռ��� 
$sql  = "SELECT";
$sql .= "   MAX(to_char(renew_time,'yyyy/mm/dd hh24:mi'))";
$sql .= " FROM";
$sql .= "   t_sys_renew ";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= " AND";
$sql .= "   renew_div=4 ";
$sql .= ";";

$result = Db_Query($conn, $sql);

$renew_before = pg_fetch_result($result,0,0);

//���������������(������ʬ)
$sql  = "SELECT";
$sql .= "   close_day,";                                  //Ĵ��ɽ������
$sql .= "   to_char(renew_time,'yyyy/mm/dd hh24:mi')";    //��������
$sql .= " FROM";
$sql .= "   t_sys_renew ";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= " AND";
$sql .= "   renew_div=4 ";
$sql .= " ORDER BY renew_time DESC LIMIT 50 OFFSET 0;";

$result = Db_Query($conn, $sql);
$page_data = Get_Data($result);

//�¹ԥܥ��󤬲����줿���
if($_POST["jikkou_button_flg"] == 'true'){

    //�����Ͽ���ê�����ʤ���
    $sql  = "SELECT \n";
    $sql .= "    COUNT(t_invent.invent_id) \n";
    $sql .= "FROM \n";
    $sql .= "    t_invent \n";
    $sql .= "    INNER JOIN \n";
    $sql .= "    ( \n";
    $sql .= "        SELECT \n";
    $sql .= "            invent_id, \n";
    $sql .= "            COUNT(goods_id) AS all_num \n";
    $sql .= "        FROM \n";
    $sql .= "            t_contents \n";
    $sql .= "        GROUP BY \n";
    $sql .= "            invent_id \n";
    $sql .= "    ) AS contents1 ON t_invent.invent_id = contents1.invent_id \n";
    $sql .= "    LEFT JOIN \n";
    $sql .= "    ( \n";
    $sql .= "        SELECT \n";
    $sql .= "            invent_id, \n";
    $sql .= "            COUNT(goods_id) AS input_num \n";
    $sql .= "        FROM \n";
    $sql .= "            t_contents \n";
    $sql .= "        WHERE \n";
    $sql .= "            staff_id IS NOT NULL \n";
    $sql .= "        GROUP BY \n";
    $sql .= "            invent_id \n";
    $sql .= "    ) AS contents2 ON t_invent.invent_id = contents2.invent_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_invent.renew_flg = false \n";
    $sql .= "    AND \n";
    $sql .= "    t_invent.shop_id = $shop_id \n";
    $sql .= "    AND \n";
    $sql .= "    contents1.all_num != contents2.input_num \n";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    //�����Ͽ���ê�����ʤ����
    if(pg_fetch_result($result, 0, 0) == 0){

        //Ĵ��ɽ�����������
        $sql = "SELECT ";
        $sql .= "   expected_day";
        $sql .= " FROM";
        $sql .= "   t_invent ";
        $sql .= " WHERE";
        $sql .= "   shop_id = $shop_id";
        $sql .= " AND";
        $sql .= "   renew_flg = 'f'";
        $result = Db_Query($conn, $sql);
        if(pg_num_rows($result) != 0){
            $expected_day = @pg_fetch_result($result,0,0);

            //Ĵ��ɽ�����ä����
            if($expected_day != null){

                Db_Query($conn, "BEGIN;");

                //ê�����ۤ��ʧ����Ͽ
                $sql  = "INSERT INTO \n";
                $sql .= "    t_stock_hand \n";
                $sql .= "( \n";
                $sql .= "    goods_id, \n";         // 1 ����ID
                $sql .= "    enter_day, \n";        // 2 ������
                $sql .= "    work_day, \n";         // 3 ��ȼ»���
                $sql .= "    work_div, \n";         // 4 ��ȶ�ʬ
                $sql .= "    ware_id, \n";          // 5 �Ҹ�ID
                $sql .= "    io_div, \n";           // 6 ���и˶�ʬ
                $sql .= "    num, \n";              // 7 ����
                $sql .= "    adjust_price, \n";     // 8 Ĵ��ñ��
                $sql .= "    staff_id, \n";         // 9 ��ȼ�ID
                $sql .= "    shop_id, \n";          //10 ����å�ID
                $sql .= "    adjust_reason \n";     //11 Ĵ����ͳ
                $sql .= ") \n";

                $sql .= "SELECT \n";
                $sql .= "    t_contents.goods_id, \n";
                $sql .= "    CURRENT_TIMESTAMP, \n";
                $sql .= "    t_invent.expected_day, \n";
                $sql .= "    '6', \n";              // 4 ��ȶ�ʬ��Ĵ����
                $sql .= "    t_invent.ware_id, \n";
                $sql .= "    CASE \n";              // 6 ���и˶�ʬ
                $sql .= "        WHEN (t_contents.tstock_num - t_contents.stock_num) > 0 THEN 1 \n";    //Ģ�������ê����¿���������ˡ�
                $sql .= "        ELSE 2 \n";                                                            //����ʳ��ϡֽиˡ�
                $sql .= "    END, \n";
                $sql .= "    ABS(t_contents.tstock_num - t_contents.stock_num), \n";
                $sql .= "    t_price.r_price, \n";
                $sql .= "    ".$_SESSION["staff_id"].", \n";
                $sql .= "    t_invent.shop_id, \n";
                $sql .= "    CASE t_contents.cause \n";
                $sql .= "        WHEN '��»' THEN '2' \n";
                $sql .= "        WHEN 'ʶ��' THEN '3' \n";
                $sql .= "        WHEN 'ȯ��' THEN '4' \n";
                $sql .= "        WHEN '�߸˵����ߥ�' THEN '5' \n";
                $sql .= "        WHEN 'Ĵ��' THEN '7' \n";
                $sql .= "    END \n";
                $sql .= "FROM \n";
                $sql .= "    t_invent \n";
                $sql .= "    INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
                $sql .= "    INNER JOIN t_price ON t_contents.goods_id = t_price.goods_id \n";
                $sql .= "WHERE \n";
                $sql .= "    t_invent.shop_id = $shop_id \n";
                $sql .= "    AND \n";
                $sql .= "    t_invent.renew_flg = false \n";
                $sql .= "    AND \n";
                $sql .= "    (t_contents.tstock_num - t_contents.stock_num) != 0 \n";
                $sql .= "    AND \n";
                if($group_kind == "1"){
                    //Ĵ��ñ���������ϡ��ղáפ���Ͽ
                    $sql .= "    t_price.rank_cd = '1' \n";
                }else{
                    //Ĵ��ñ����FC�ϡֺ߸�ñ���פ���Ͽ
                    $sql .= "    t_price.rank_cd = '3' \n";
                }
                $sql .= "    AND \n";
                $sql .= "    t_price.shop_id = $shop_id \n";

                $sql .= ";";

                $result = Db_Query($conn, $sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }


                //ê���إå��ơ��֥빹��
                $sql  = " UPDATE t_invent SET ";
                $sql .= "   renew_flg = 't',";
                $sql .= "   renew_time = NOW(),";
                $sql .= "   staff_name = (SELECT t_staff.staff_name FROM t_staff WHERE t_staff.staff_id = t_invent.staff_id)";
                $sql .= " WHERE ";
                $sql .= "   shop_id = $shop_id";
                $sql .= " AND";
                $sql .= "   renew_flg = 'f'";
                $sql .= " ;";
                $result = Db_Query($conn, $sql);

                //���Ԥ������ϥ���Хå�
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }

                //������������ơ��֥����Ͽ
                $sql  = " INSERT INTO t_sys_renew( ";
                $sql .= "    renew_id,";
                $sql .= "    renew_div,";
                $sql .= "    renew_time,";
                $sql .= "    close_day,";            //Ĵ��ɽ������
                $sql .= "    shop_id";
                $sql .= ")VALUES(";
                $sql .= "    (SELECT COALESCE(MAX(renew_id), 0)+1 FROM t_sys_renew),";
                $sql .= "    '4',";
                $sql .= "    NOW(),";
                $sql .= "    '$expected_day',";
                $sql .= "    '$shop_id'";
                $sql .= ");";
                $result = Db_Query($conn, $sql);

                //���Ԥ������ϥ���Хå�
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }
                Db_Query($conn, "COMMIT;");
            header("Location: ".$pre_url."?done=t");
            }
        }else{
            $exec_err_mess = "������ǽ��ê��Ĵ��ɽ�Ϥ���ޤ���";
        }

    //�����Ͽ���ê���������硢���顼��å�����ɽ��
    }else{
        $temp_err_mess = "�����Ͽ���ê��Ĵ��ɽ������ޤ���";
    }

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
//��˥塼����
/****************************/
//$page_menu = Create_Menu_f('renew','1');

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
    'renew_before'  => "$renew_before",
    'complete_msg'  => "$complete_msg",
    'exec_err_mess' => "$exec_err_mess",
    'temp_err_mess' => "$temp_err_mess",
));

$smarty->assign("page_data",$page_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
