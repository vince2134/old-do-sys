<?php

// ��˥塼���̰���(����)
function Create_Menu_h($head_menu, $select_menu){
}


// ��˥塼���̰���(FC)
function Create_Menu_f($fc_menu, $select_menu){
}


// �ͤ��˥�˥塼����
function Create_Menu($menu, $select_menu, $menu_disp, $where_menu, $menu_color){

    // Ϣ�������ź��������
    $data_menu = array_keys($menu_disp);

    // TOP�ڡ����μ���
    if ($where_menu == "head"){
        $top_page = TOP_PAGE_H; // TOP��������
    }else{
        $top_page = TOP_PAGE_F; // TOP��FC��
    }

    $table_m = null;

    $table_m .= "<table border=\"0\">\n";
    $table_m .= "    <tr>\n";
    $table_m .= "        <td>\n";
    $table_m .= "            <table width=\"158px\" class=\"Menu_Table\">\n";
    $table_m .= "                <tr>\n";
    $table_m .= "                    <td align=\"left\">\n";
    $table_m .= "                        <a href=\"$top_page\" class=\"MyMenu2\" tabindex=\"-1\"><div class=\"backcolor\">�ᥤ���˥塼</div></a>\n";
    $table_m .= "                    </td>\n";
    $table_m .= "                </tr>\n";

    $i = 1;

    // ��˥塼¸�ߥ����å��Ѥ˥��ԡ�
    $menu_disp2 = $menu_disp;

    // ��˥塼¸�ߥ����å��ե饰
    $find_flg = false;

    while ($main_menu = each($menu_disp)){

        // �ᥤ���˥塼̾��
        // $main_menu[0]
        $table_m .= "                <tr>\n";
        $table_m .= "                    <td class=\"Sub_Menu\" valign=\"middle\">\n";
        $table_m .= "                        <table border=\"0\" id=\"$main_menu[0]\" width=\"100%\">\n";
        $table_m .= "                            <tr>\n";
        $table_m .= "                                <td>\n";
        $table_m .= "                                    <div class=\"Menu\">\n";
        // �ޥ��������ξ�����bottom�ޡ����󤬰㤦�١����饹��ʬ���Ƥ���
        if($main_menu[0] == "�ޥ�������"){
            $table_m .= "                                    <div class=\"Main_Menu_M\"><font size=\"+0.5\" color=\"#555555\"><b>$main_menu[0]</b></font></div>\n";
        }else{
            $table_m .= "                                    <div class=\"Main_Menu\"><font size=\"+0.5\" color=\"#555555\"><b>$main_menu[0]</b></font></div>\n";
        }
        $j = 0;

        // $sub_menu[0]��URL
        // $sub_menu[1]������̾��
        while ($sub_menu = each($main_menu[1])){
            // ���ߤβ��̤���˥塼���ܤ�¸�ߤ��뤫
            while ($m_menu = each($menu_disp2)){
                while ($s_menu = each($m_menu[1])){
                    if (basename($_SERVER["PHP_SELF"]) == basename($s_menu[0])){
                        // ��˥塼��¸�ߤ���
                        $find_flg = true;
                        // ��˥塼�ˤʤ����Τ��ͤ��ݻ�
                        $_SESSION["display"] = null;
                        break;
                    }
                }
            }

            // ����ɽ�������Ƥ����˥塼�Ͽ����Ѥ���(CSS���ѹ�) 
            // ��˥塼��¸�ߤ��ʤ����̤ʤ顢�������β��̤˿����դ���

            // GET�����ղä���Ƥ����礬����١�?��ʬ�䤷URL����
            $referer_flg    = "false";
            $referer_name   = explode("?", $_SERVER["HTTP_REFERER"]);
            // GET����ξ��ϡ�$_SESSION[display]��ʬ�䤷��URL������
            if (count($referer_name) != 0){
                $referer_flg = "true";
            }

            if ((basename($_SERVER["PHP_SELF"]) == basename($sub_menu[0])) ||
                ($find_flg == false && basename($_SERVER["HTTP_REFERER"]) == basename($sub_menu[0])) ||
                ($find_flg == false && basename($referer_name[0]) == basename($sub_menu[0]))
            ){
                $css_class = "MyMenu";
                // ��˥塼�ˤʤ����ϡ��������β��̤򥻥å������ݻ�����
                if ($find_flg == false){
                    if ($referer_flg == "true"){
                        $_SESSION["display"] = basename($referer_name[0]);
                    }else{
                        $_SESSION["display"] = basename($_SERVER["HTTP_REFERER"]);
                    }
                }
            }else{
                // ��ե��顼�β��̤���˥塼��̵�����ϡ����å����β��̤˿����դ���
                if ($_SESSION["display"] == basename($sub_menu[0])){
                    $css_class = "MyMenu";
                }else{
                    $css_class = "MyMenu2";
                }
            }

            // ���̹���̾
            if ($sub_menu[1][1] == "form3"){
                $table_m .= "                                        <div class=\"M_Menu\">\n";
                $table_m .= "                                            <a class=\"M_Menu\" tabindex=\"-1\">".$sub_menu[1][0]."</a>\n";
                $table_m .= "                                        </div>\n";
                $table_m .= "                                        <br>\n";
            // ��Ĥβ���̾
            }else
            if ($sub_menu[1][1] == "form1"){
                if ($css_class == "MyMenu"){
                    $css_class2 = "MyMenu";
                }else{
                    $css_class2 = "M_Menu";
                }
                $table_m .= "                                        <div class=\"$css_class\">\n";
                $table_m .= "                                            <a href=\"$sub_menu[0]\" class=\"$css_class2\" tabindex=\"-1\">".$sub_menu[1][0]."</a>\n";
                $table_m .= "                                        </div>\n";
                $table_m .= "                                        <br>\n";
            }
            // ��������ѿ�
            $_SESSION["form"] = $sub_menu[1][1];
            // ��˥塼����ѿ�
            $_SESSION["main"] = $main_menu[0];
            $j++;

        }

        $table_m .= "                                    </div>\n";
        $table_m .= "                                </td>\n";
        $table_m .= "                            </tr>\n";
        $table_m .= "                        </table>\n";
        $table_m .= "                    </td>\n";
        $table_m .= "                </tr>\n";
        $table_m .= "                <tr>\n";
        $table_m .= "                    <td height=\"10\">\n";
        $table_m .= "                    </td>\n";
        $table_m .= "                </tr>\n";
        $i++;

    }

    // LOGOUT
    $logout_page = LOGOUT_PAGE;

    $table_m .= "            </td>\n";
    $table_m .= "        </tr>\n";
    $table_m .= "        <tr>\n";
    $table_m .= "            <td align=\"left\">\n";
    $table_m .= "                <a href=\"$logout_page\" class=\"MyMenu2\" tabindex=\"-1\"><div class=\"backcolor2\">�������� ��������</div></a>\n";
    $table_m .= "                            </td>\n";
    $table_m .= "                        </tr>\n";
    $table_m .= "                    </td>\n";
    $table_m .= "                </tr>\n";
    $table_m .= "            </table>\n";
    $table_m .= "        </td>\n";
    $table_m .= "    </tr>\n";
    $table_m .= "</table>\n";

    return $table_m;
}


/**
 *
 * ���̾�Υإå���ʬ����˥塼���������
 *
 * @param       string      $title       �ڡ��������ȥ�
 *
 * @return      bool        $table_h     �������줿HTML
 *
 * @author      
 * @version     1.0.0 (2006/04/18)
 *
 */

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2010/09/04                  aoyama-n    ��˥塼�������ѹ�
 *  2010/09/04                  aoyama-n    �֥����ƥ�����פ�ֻĹ�������פ��ѹ�
*/
function Create_Header($title){

    // PATH��ʸ���������
    $count_path = mb_strwidth(PATH);
    // ���HEAD_PAGE����PATH��ȴ������ʬ�����
    $head = mb_substr(HEAD_DIR, $count_path);
    // ���ߤ�URL�����HEAD_PAGE����PATH��ȴ������ʬ���ޤޤ�Ƥ��뤫
    $which = strstr($_SERVER["PHP_SELF"], $head);

    //�嵭�ϥ����ȥ�����
    $which = ($_SESSION["group_kind"] != '1')? false:true; 

    // �饤��
    $background = IMAGE_DIR."line.png";
    $head_img = "<img src=\"../../../image/head_img.png\">";
    $db_con = Db_Connect();


    /*** ���Ѳ�ǽ�ʥ����åդ�Ĵ�٤� ***/
    $sql = "SELECT staff_id FROM t_staff WHERE staff_id = ".$_SESSION["staff_id"]." AND state = '�߿���';";
    $res = Db_Query($db_con, $sql);
    // ¸�ߤ��ʤ������åդξ��
    if (pg_num_rows($res) == 0){
        // ���å������˴�����
        session_start();
        session_unset();
        session_destroy();
        // ��������̤�����
        header("Location: ../top.php");
        exit;
    }

    /*** ���¤�������� ***/
    // �⥸�塼���ֹ�����������̾����
    $page_name   = substr($_SERVER["PHP_SELF"], strrpos($_SERVER["PHP_SELF"], "/")+1);
    $module_name = substr($page_name, 0,  strpos($page_name, "."));
    $column_name = str_replace("-", "_", substr_replace($module_name, substr($module_name, 0, 1) == "1" ? "h" : "f", 0, 1));

    // ���¥����å�����������������������
    $permit_col  = Permit_Col("head");
    foreach ($permit_col as $key_hf => $value_hf){
        foreach ($value_hf as $key_1 => $value_1){
            foreach ($value_1 as $key_2 => $value_2){
                foreach ($value_2 as $key_3 => $value_3){
                    foreach ($value_3 as $key_4 => $value_4){
                        $ary_column_name[] = $value_4;
                    }       
                }
            }
        }
    }

    // ���¥����å��⥸�塼������˺ܤäƤ�⥸�塼��ϸ��¥����å���Ԥ�
    if (in_array($column_name, $ary_column_name)){
        $auth       = Auth_Check($db_con);
        $auth_msg   = ($auth[3] != null) ? $auth[3] : null;
    }

    // �����ξ��
    if ($which != false){

        // ������
        $menu_path = PATH."src/head/sale";
        $set_menu[0] = array (
            "menu" => "������",
            "1" => "������",
            "$menu_path/1-2-102.php" => "����饤�����",
            "$menu_path/1-2-101.php" => "��������",
            "$menu_path/1-2-105.php" => "����Ȳ�",
            "$menu_path/1-2-106.php" => "����İ���",
            "$menu_path/1-2-130.php" => "��󥿥�TO��󥿥�",
            "2" => "�����",
            "$menu_path/1-2-201.php" => "�������",
            "$menu_path/1-2-203.php" => "���ʳ���˾Ȳ�",
            "$menu_path/1-2-209.php" => "Ǽ�ʽ�������",
            //"$menu_path/1-2-202.php" => "�����ɼ���ȯ��",
            "3" => "�������",
            "$menu_path/1-2-301.php" => "����ǡ��������Ȳ�",
            "4" => "�������",
            "$menu_path/1-2-402.php" => "��������",
            "$menu_path/1-2-403.php" => "����Ȳ�",
            "5" => "���Ӵ���",
            "$menu_path/1-2-501.php" => "��ݻĹ����",
            "$menu_path/1-2-503.php" => "����踵Ģ",
        );

        // ��������
        $menu_path = PATH."src/head/buy";
        $set_menu[1] = array (
            "menu" => "��������",
            "1" => "ȯ����",
            "$menu_path/1-3-101.php" => "ȯ�����ٹ�ꥹ��",
            "$menu_path/1-3-102.php" => "ȯ������",
            "$menu_path/1-3-104.php" => "ȯ��Ȳ�",
            "$menu_path/1-3-106.php" => "ȯ��İ���",
            "2" => "�������",
            "$menu_path/1-3-207.php" =>"��������",
            "$menu_path/1-3-202.php" =>"�����Ȳ�",
            "3" => "��ʧ����",
            "$menu_path/1-3-307.php" => "����������",
            "$menu_path/1-3-302.php" => "��ʧ����",
            "$menu_path/1-3-303.php" => "��ʧ�Ȳ�",
            "4" => "���Ӵ���",
            "$menu_path/1-3-401.php" => "��ݻĹ����",
            "$menu_path/1-3-403.php" => "�����踵Ģ",
        );

        // �߸˴���
        $menu_path = PATH."src/head/stock";
        $set_menu[2] = array (
            "menu" => "�߸˴���",
            "1" => "�߸˼��",
            "$menu_path/1-4-101.php" => "�߸˾Ȳ񡿼�ʧ",
            "$menu_path/1-4-107.php" => "�߸˰�ư",
            "$menu_path/1-4-109.php" => "������Ω",
            "$menu_path/1-4-104.php" => "���ʥ��롼������",
            "2" => "ê������",
            "$menu_path/1-4-201.php" => "ê��Ĵ��ɽ",
            "$menu_path/1-4-108.php" => "�߸�Ĵ������",
        );

        // ����
        $menu_path = PATH."src/head/renew";
        $set_menu[3] = array (
            "menu" => "��������",
            "1" => "��������",
            "$menu_path/1-5-105.php" => "�Хå�ɽ",
            "$menu_path/1-5-107.php" => "���ڥ졼�����Ͼ���",
            "$menu_path/1-5-101.php" => "������������",
            "$menu_path/1-5-104.php" => "ê����������",
            "$menu_path/1-5-102.php" => "���������",
        );

        // �ǡ�������
//        $menu_path = PATH."src/head/analysis";
        $menu_path = PATH."src/analysis/head";
        $set_menu[4] = array (
            "menu" => "�ǡ�������",
            "1" => "���׾���",
            "$menu_path/1-6-132.php" => "�������",
            //"$menu_path/1-6-131.php" => "��������",
            //"$menu_path/1-6-135.php" => "�����̷�������",
            //"$menu_path/1-6-133.php" => "�������̷�������",
            //"$menu_path/1-6-143.php" => "����۰���",
            "2" => "�����",
            "$menu_path/1-6-103.php" => "�ƣ���",
            //"$menu_path/1-6-100.php" => "�����ӥ���",
            "$menu_path/1-6-101.php" => "������",
            "$menu_path/1-6-108.php" => "ô�����̾�����",
            //"$menu_path/1-6-105.php" => "�϶��̾�����",
            "$menu_path/1-6-106.php" => "�ȼ��̣ƣ���",
            "$menu_path/1-6-107.php" => "�ȼ��̾�����",
            "3" => "ABCʬ��",
            "$menu_path/1-6-112.php" => "FC��",
            "$menu_path/1-6-110.php" => "������",
            "$menu_path/1-6-111.php" => "FC�̾�����",
            "$menu_path/1-6-113.php" => "�ȼ���",
            "$menu_path/1-6-114.php" => "ô������",
            "4" => "�������",
            "$menu_path/1-6-122.php" => "��������",
            "$menu_path/1-6-121.php" => "�������̾�����",
            "5" => "CSV����",
            "$menu_path/1-6-301.php" => "�ޥ����ǡ���",
            "$menu_path/1-6-302.php" => "���ӥǡ���",
            "$menu_path/1-6-303.php" => "�ޥ�������",
        );

        // �ޥ���������
        $menu_path = PATH."src/head/system";
        $set_menu[5] = array (
            "menu" => "�ޥ���������",
            "1" => "���������ޥ���",
            "$menu_path/1-1-205.php" => "�ȼ�",
            "$menu_path/1-1-234.php" => "����",
            "$menu_path/1-1-233.php" => "����",
            "$menu_path/1-1-231.php" => "�����ӥ�",
            "$menu_path/1-1-230.php" => "������",
            "2" => "������ͭ�ޥ���",
            "$menu_path/1-1-211.php" => "�Ͷ�ʬ",
            "$menu_path/1-1-209.php" => "������ʬ",
            "$menu_path/1-1-235.php" => "����ʬ��",
            "$menu_path/1-1-220.php" => "����",
            "3" => "���̥ޥ���",
            "$menu_path/1-1-203.php" => "�Ҹ�",
            "$menu_path/1-1-201.php" => "����",
            "$menu_path/1-1-213.php" => "�϶�",
            "$menu_path/1-1-207.php" => "���",
            "$menu_path/1-1-107.php" => "�����å�",
            "$menu_path/1-1-302.php" => "�ѥ�����ѹ�",
            "$menu_path/1-1-227.php" => "FC��������ʬ",
            "$menu_path/1-1-101.php" => "FC�������",
            "$menu_path/1-1-113.php" => "������",
            "$menu_path/1-1-219.php" => "ľ����",
            "$menu_path/1-1-225.php" => "�����ȼ�",
            "$menu_path/1-1-224.php" => "��¤��",
            "4" => "Ģɼ����",
            "$menu_path/1-1-303.php" => "ȯ��񥳥���",
            "$menu_path/1-1-304.php" => "��ʸ��̎����ώ�������",
            "$menu_path/1-1-312.php" => "Ǽ�ʽ�",
            "$menu_path/1-1-310.php" => "�����",
            "5" => "�����ƥ�����",
            "$menu_path/1-1-301.php" => "�����ץ�ե�����",
            "$menu_path/1-1-305.php" => "��ݻĹ�������",
            "$menu_path/1-1-306.php" => "��ݻĹ�������",
            "$menu_path/1-1-307.php" => "����Ĺ�������",
        );

    // ľ�ġ�FC��
    }else{
    
        // ������
        $menu_path = PATH."src/franchise/sale";
        $menu_path_system = PATH."src/franchise/system";
        $set_menu[0] = array (
            "menu" => "������",
            "1" => "ͽ����",
            "$menu_path/2-2-101-2.php" => "��󥫥�����",
            "$menu_path/2-2-113.php" => "����������ɼȯ��",
            "$menu_path/2-2-118.php" => "ͽ������ɼȯ��",
            "$menu_path/2-2-206.php" => "ͽ����ɼ������",
            "$menu_path/2-2-209.php" => "�����ɼ����",
            "2" => "�����",
            "$menu_path/2-2-201.php" => "�����ɼȯ��",
            "$menu_path/2-2-207.php" => "���������",
            "$menu_path/2-2-210.php" => "�����ɼ(����)����",
            "3" => "�������",
            "$menu_path/2-2-301.php" => "����ǡ��������Ȳ�",
            "4" => "�������",
            "$menu_path/2-2-402.php" => "��������",
            "$menu_path/2-2-403.php" => "����Ȳ�",
            "$menu_path/2-2-411.php" => "����������",
            "$menu_path/2-2-412.php" => "������Ȳ�",
            "$menu_path/2-2-414.php" => "������Ĺ����",
            "$menu_path/2-2-415.php" => "�������ʧ����",
            "5" => "���Ӵ���",
            "$menu_path/2-2-501.php" => "��ݻĹ����",
            "$menu_path/2-2-503.php" => "�����踵Ģ",
        );

        // ��������
        $menu_path = PATH."src/franchise/buy";
        $menu_path_system = PATH."src/franchise/system";
        $set_menu[1] = array (
            "menu" => "��������",
            "1" => "ȯ����",
            "$menu_path/2-3-101.php" => "ȯ�����ٹ�ꥹ��",
            "$menu_path/2-3-102.php" => "ȯ������",
            "$menu_path/2-3-104.php" => "ȯ��Ȳ�",
            "$menu_path/2-3-106.php" => "ȯ��İ���",
            "$menu_path_system/2-1-142.php" => "��󥿥�TO��󥿥�",
            "2" => "�������",
            "$menu_path/2-3-201.php" =>"��������",
            "$menu_path/2-3-202.php" =>"�����Ȳ�",
            "3" => "��ʧ����",
            "$menu_path/2-3-307.php" => "����������",
            "$menu_path/2-3-302.php" => "��ʧ����",
            "$menu_path/2-3-303.php" => "��ʧ�Ȳ�",
            "4" => "���Ӵ���",
            "$menu_path/2-3-401.php" => "��ݻĹ����",
            "$menu_path/2-3-403.php" => "�����踵Ģ",
        );

        // �߸˴���
        $menu_path = PATH."src/franchise/stock";
        $set_menu[2] = array (
            "menu" => "�߸˴���",
            "1" => "�߸˼��",
            "$menu_path/2-4-101.php" => "�߸˾Ȳ񡿼�ʧ",
            "$menu_path/2-4-107.php" => "�߸˰�ư",
            "2" => "ê������",
            "$menu_path/2-4-201.php" => "ê��Ĵ��ɽ",
            "$menu_path/2-4-108.php" => "�߸�Ĵ������",
        );

        // ����
        $menu_path = PATH."src/franchise/renew";
        $set_menu[3] = array (
            "menu" => "��������",
            "1" => "��������",
            "$menu_path/2-5-105.php" => "�Хå�ɽ",
            "$menu_path/2-5-107.php" => "���ڥ졼�����Ͼ���",
            "$menu_path/2-5-101.php" => "������������",
            "$menu_path/2-5-104.php" => "ê����������",
            "$menu_path/2-5-102.php" => "���������",
        );

        // �ǡ�������
//        $menu_path = PATH."src/franchise/analysis";
        $menu_path = PATH."src/analysis/franchise";
        $set_menu[4] = array (
            "menu" => "�ǡ�������",
            "1" => "���׾���",
            "$menu_path/2-6-132.php" => "�������",
            //"$menu_path/2-6-131.php" => "��������",
            //"$menu_path/2-6-137.php" => "�����̷�������",
            //"$menu_path/2-6-135.php" => "�������̷�������",
            //"$menu_path/2-6-151.php" => "�롼��ͽ��ɽ",
            //"$menu_path/2-6-153.php" => "��§���ܵҰ���",
            "2" => "�����",
            "$menu_path/2-6-103.php" => "��������",
            "$menu_path/2-6-100.php" => "�����ӥ���",
            //"$menu_path/2-6-101.php" => "������",
            "$menu_path/2-6-108.php" => "ô�����̾�����",
            //"$menu_path/2-6-104.php" => "�϶�����������",
            "$menu_path/2-6-106.php" => "�ȼ�����������",
            "3" => "ABCʬ��",
            "$menu_path/2-6-112.php" => "��������",
            "$menu_path/2-6-110.php" => "������",
            "$menu_path/2-6-114.php" => "ô������",
            "4" => "�������",
            "$menu_path/2-6-122.php" => "��������",
            "$menu_path/2-6-121.php" => "�������̾�����",
            "5" => "CSV����",
            "$menu_path/2-6-201.php" => "�ޥ����ǡ���",
            "$menu_path/2-6-202.php" => "���ӥǡ���",
            "$menu_path/2-6-203.php" => "�ޥ�������",
        );

        // �ޥ���������
        $menu_path = PATH."src/franchise/system";
        // ľ�Ļ�
        if ($_SESSION["group_kind"] == "2"){
            #2010-09-04 aoyama-n
            #��˥塼�����ѹ�
            $set_menu[5] = array (
                "menu" => "�ޥ���������",
                "1" => "���̥ޥ���",
                "$menu_path/2-1-301.php" => "���ҥץ�ե�����",
                "$menu_path/2-1-350.php" => "��������",
                "$menu_path/2-1-203.php" => "�Ҹ�",
                "$menu_path/2-1-200.php" => "�ܻ�Ź",
                "$menu_path/2-1-201.php" => "����",
                "$menu_path/2-1-213.php" => "�϶�",
                "$menu_path/2-1-207.php" => "���",
                "$menu_path/2-1-107.php" => "�����å�",
                "$menu_path/2-1-302.php" => "�ѥ�����ѹ�",
                "$menu_path/2-1-219.php" => "ľ����",
                "$menu_path/2-1-225.php" => "�����ȼ�",
                "$menu_path/2-1-215.php" => "������",
                "$menu_path/2-1-113.php" => "���롼��",
                #2010-04-06 hashimoto-y
                #"$menu_path/2-1-103.php" => "������",
                "$menu_path/2-1-101.php" => "������",
                "$menu_path/2-1-111.php" => "����",
                "2" => "������ͭ�ޥ���",
                "$menu_path/2-1-211.php" => "�Ͷ�ʬ",
                "$menu_path/2-1-209.php" => "������ʬ",
                "$menu_path/2-1-241.php" => "����ʬ��",
                "$menu_path/2-1-220.php" => "����",
                "3" => "Ģɼ����",
                "$menu_path/2-1-303.php" => "ȯ��񥳥���",
                "$menu_path/2-1-308.php" => "�����ɼ",
                "$menu_path/2-1-307.php" => "�����",
                "4" => "�Ĺ�������",
                "$menu_path/2-1-304.php" => "��ݻĹ�������",
                "$menu_path/2-1-305.php" => "��ݻĹ�������",
                "$menu_path/2-1-306.php" => "����Ĺ�������",
                "5" => "���������ޥ���",
                "$menu_path/2-1-231.php" => "�ȼ�",
                "$menu_path/2-1-234.php" => "����",
                "$menu_path/2-1-233.php" => "����",
                "$menu_path/2-1-232.php" => "�����ӥ�",
                "$menu_path/2-1-229.php" => "������",
            );
        // FC��
        }else{
            #2010-09-04 aoyama-n
            #��˥塼�����ѹ�
            $set_menu[5] = array (
                "menu" => "�ޥ���������",
                "1" => "���̥ޥ���",
                "$menu_path/2-1-301.php" => "���ҥץ�ե�����",
                "$menu_path/2-1-350.php" => "��������",
                "$menu_path/2-1-203.php" => "�Ҹ�",
                "$menu_path/2-1-200.php" => "�ܻ�Ź",
                "$menu_path/2-1-201.php" => "����",
                "$menu_path/2-1-213.php" => "�϶�",
                "$menu_path/2-1-207.php" => "���",
                "$menu_path/2-1-107.php" => "�����å�",
                "$menu_path/2-1-302.php" => "�ѥ�����ѹ�",
                "$menu_path/2-1-219.php" => "ľ����",
                "$menu_path/2-1-225.php" => "�����ȼ�",
                "$menu_path/2-1-239.php" => "��԰���",
                "$menu_path/2-1-215.php" => "������",
                "$menu_path/2-1-113.php" => "���롼��",
                #2010-04-06 hashimoto-y
                #"$menu_path/2-1-103.php" => "������",
                "$menu_path/2-1-101.php" => "������",
                "$menu_path/2-1-111.php" => "����",
                "2" => "������ͭ�ޥ���",
                "$menu_path/2-1-211.php" => "�Ͷ�ʬ",
                "$menu_path/2-1-209.php" => "������ʬ",
                "$menu_path/2-1-241.php" => "����ʬ��",
                "$menu_path/2-1-220.php" => "����",
                "3" => "Ģɼ����",
                "$menu_path/2-1-303.php" => "ȯ��񥳥���",
                "$menu_path/2-1-308.php" => "�����ɼ",
                "$menu_path/2-1-307.php" => "�����",
                "4" => "�Ĺ�Ĺ�����",
                "$menu_path/2-1-304.php" => "��ݻĹ�������",
                "$menu_path/2-1-305.php" => "��ݻĹ�������",
                "$menu_path/2-1-306.php" => "����Ĺ�������",
                "5" => "���������ޥ���",
                "$menu_path/2-1-231.php" => "�ȼ�",
                "$menu_path/2-1-234.php" => "����",
                "$menu_path/2-1-233.php" => "����",
                "$menu_path/2-1-232.php" => "�����ӥ�",
                "$menu_path/2-1-229.php" => "������",
            );
        }

    }

    // �������ץ���������
    $set_name[0] = "form_sale";
    $set_arr[0]  = Make_Slct_Html($set_name[0]);
    // �����ץ���������
    $set_name[1] = "form_buy";
    $set_arr[1]  = Make_Slct_Html($set_name[1]);
    // �߸˥ץ���������
    $set_name[2] = "form_stock";
    $set_arr[2]  = Make_Slct_Html($set_name[2]);
    // �����ץ���������
    $set_name[3] = "form_renew";
    $set_arr[3]  = Make_Slct_Html($set_name[3]);
    // ���ץץ���������
    $set_name[4] = "form_analy";
    $set_arr[4]  = Make_Slct_Html($set_name[5]);
    // �ޥ���������ץ���������
    $set_name[5] = "form_system";
    $set_arr[5]  = Make_Slct_Html($set_name[4]);

    //���ߤβ��̤��ɤΥǥ��쥯�ȥ�ʤΤ�Ƚ�ꤹ������
    $menu_name[0] = "sale";
    $menu_name[1] = "buy";
    $menu_name[2] = "stock";
    $menu_name[3] = "renew";
    $menu_name[4] = "analysis";
    $menu_name[5] = "system";

    $staff_name   = htmlspecialchars($_SESSION["staff_name"]);
    $shop_name    = htmlspecialchars($_SESSION["h_shop_name"]);
    $fc_shop_name = htmlspecialchars($_SESSION["fc_client_name"]);

    $count = count($set_menu);
    for ($x = 0; $x < $count; $x++){
        $num = 1;
        while ($main_menu = each($set_menu[$x])){
            // �ƥ��롼��̾�ξ��
            if ($main_menu[0] == $num){
                $set_arr[$x] .= "    <OPTGROUP LABEL=\"��$main_menu[1]\" style=\"background-color:#828180; color:#FEFEFE; font-weight:lighter;\">\n";
            }else
            // ��˥塼̾�ξ��
            if($main_menu[0] == "menu"){
                // ���ߤβ��̤Υ�˥塼�Ͽ����ѹ�����
                if (ereg($menu_name[$x], $_SERVER["PHP_SELF"])){
                    // ���ߤΥ�˥塼
                    $set_arr[$x] .= "    <option value=\"$main_menu[0]\" style='background-color:#FDFD66;'>$main_menu[1]</option>\n";
                }else{
                    // ����¾�Υ�˥塼
                    $set_arr[$x] .= "    <option value=\"$main_menu[0]\" style='background-color:#EEEEEE;'>$main_menu[1]</option>\n";
                }
            }else{
            // ��<option>�ξ��
                $set_arr[$x] .= "    <option value=\"$main_menu[0]\">$main_menu[1]</option>\n";
            }
            // ���롼�פ��ͤ�̵���ʤä����ϡ����롼�פ��Ĥ���
            if ($main_menu[0] == $num){
                $set_arr[$x] .= "    </OPTGROUP>\n";
                $num++;
            }
        }
        $set_arr[$x] .= "</select>\n";
    }

    // ������
    if ($which != false){

        $table_h  = null;
        $table_h .= "    <table align=\"left\">\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // �ץ�������˥塼
        $table_h .= "                <table width=\"100%\" bgcolor=\"#213B82\">\n";
        $table_h .= "                    <tr valign=\"middle\">\n";
        $ary_label = array("sale_label", "buy_label", "stock_label", "update_label", "data_label", "setup_label");
        foreach ($ary_label as $key => $label){
        $table_h .= "                        <td>\n";
        $table_h .= "                            <div style=\"position: relative;\">\n";
        $table_h .= "                            <img src=\"".IMAGE_DIR.$label.".gif\" border=\"0\" width=\"155px\" height=\"40px\">\n";
        $table_h .= "                            <div style=\"position: absolute; top:10px; left:10px;\">\n";
        $table_h .= "                            <font color=\"#6981E9\">".$set_arr[$key]."</font>\n";
        $table_h .= "                            </div>\n";
        $table_h .= "                            </div>\n";
        $table_h .= "                        </td>\n";
        }
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";
            
        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // �ڡ���̾
        $table_h .= "                <table width=\"100%\" style=\"margin-top: 0px; margin-bottom: 0px;\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td width=\"180px\"><font color=\"#555555\"><b>$shop_name</b></font></td>\n";
        $table_h .= "                        <td align=\"center\">$head_img&nbsp;\n";
        $table_h .= "                            <font style=\"font-size: 11pt; font-weight: bold; color:#555555;\">$title</font>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"right\" width=\"180px\">\n";
        $table_h .= "                            <a href=\"".TOP_PAGE_H."\"><img src=\"".IMAGE_DIR."main_menu.gif\" border=\"0\"></a>��\n";
        $table_h .= "                            <a href=\"".LOGOUT_PAGE."\"><img src=\"".IMAGE_DIR."logout.gif\" border=\"0\"></a>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                     </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // hr
        $table_h .= "                <table width=\"100%\" background=\"$background\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // �����å�̾
        $table_h .= "                <table width=\"100%\" style=\"margin-top: -5px;margin-bottom: -4px;\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td width=\"35%\">\n";
        $table_h .= "                            <font color=\"#555555\"><b>$staff_name</font>��<font color=\"ff0000\">$auth_msg</font></b>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"right\" width=\"35%\">\n";
        $table_h .= "                            <input type=\"button\" value=\"�̥�����ɥ��򳫤�\" onClick=\"window.open('".TOP_PAGE_H."');\">\n";


		#2008-06-19 �ѥ��ѹ��ˤ���ѹ� watanabe-k
#        $table_h .= "                            <input type=\"button\" value=\"�̥�����ɥ��򳫤�\" onClick=\"window.open('".PATH."src/window.php');\">\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "    </table>\n";

    // ľ�Ļ�
    }else{

        $table_h  = null;

        $table_h .= "    <table align=\"left\">\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // �ץ�������˥塼
        $table_h .= "            <table width=\"100%\">\n";
        $table_h .= "                <tr valign=\"middle\">\n";
        $ary_label = array("sale_label", "buy_label", "stock_label", "update_label", "data_label", "setup_label");
        foreach ($ary_label as $key => $label){
        $table_h .= "                    <td>\n";
        $table_h .= "                        <div style=\"position: relative;\">\n";
        $table_h .= "                        <img src=\"".IMAGE_DIR.$label."_fc.gif\" border=\"0\" width=\"155px\" height=\"40px\">\n";
        $table_h .= "                        <div style=\"position: absolute; top:10px; left:10px;\">\n";
        $table_h .= "                        <font color=\"#6981E9\">".$set_arr[$key]."</font>\n";
        $table_h .= "                        </div>\n";
        $table_h .= "                        </div>\n";
        $table_h .= "                    </td>\n";      
        }
        $table_h .= "                </tr>\n";
        $table_h .= "            </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // �ڡ���̾
        $table_h .= "                <table width=\"100%\" style=\"margin-top: 0px; margin-bottom: 0px;\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td width=\"180px\">\n";
        $table_h .= "                            <font color=\"#555555\"><b>$fc_shop_name</b></font>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"center\">\n";
        $table_h .= "                            <font style=\"font-size: 11pt; font-weight: bold; color:#555555\">$title</font>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"right\" width=\"180px\">\n";
        $table_h .= "                            <a href=\"".TOP_PAGE_F."\"><img src=\"".IMAGE_DIR."main_menu.gif\" border=\"0\"></a>��\n";
        $table_h .= "                            <a href=\"".LOGOUT_PAGE."\"><img src=\"".IMAGE_DIR."logout.gif\" border=\"0\"></a>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // hr
        $table_h .= "                <table width=\"100%\" background=\"$background\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // �����å�̾
        $table_h .= "                <table width=\"100%\" style=\"margin-top: -5px;margin-bottom: -4px;\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td width=\"35%\">\n";
        $table_h .= "                            <font color=\"#555555\"><b>$staff_name</font>��<font color=\"#ff0000\">$auth_msg</b></font>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"right\" width=\"35%\">\n";
        $page_name  = substr($_SERVER["PHP_SELF"], strrpos($_SERVER["PHP_SELF"], "/")+1);
        $module_no  = substr($page_name, 0, strpos($page_name, "."));
        if ($module_no == "2-2-206"){
        $table_h .= "                            <input type=\"button\" value=\"�����ɼȯ��\" onClick=\"window.open('./2-2-201.php');\">��\n";
        //��������
        }elseif ($module_no == "2-2-113"){
        $table_h .= "                            <input type=\"button\" value=\"��������ץ�ӥ塼\" onClick=\"window.open('./2-2-114.php?format=true');\">��\n";
        }
        $table_h .= "                            <input type=\"button\" value=\"�̥�����ɥ��򳫤�\" onClick=\"window.open('".TOP_PAGE_F."');\">\n";

		#2008-06-19 �ѥ��ѹ��ˤ���ѹ� watanabe-k
#        $table_h .= "                            <input type=\"button\" value=\"�̥�����ɥ��򳫤�\" onClick=\"window.open('".PATH."src/window.php');\">\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "    </table>\n";

    }

    return $table_h;

}


function Make_Slct_Html($name){

    $slct  = "<select class=\"select_title\" ";
    $slct .= "name=\"".$name."_menu\" ";
    $slct .= "style=\"width: 135px;\" ";
    $slct .= "onKeyDown=\"chgKeycode();\" ";
    $slct .= "onChange=\"window.focus(); javascript:Change_Menu(this.form, '".$name."_menu');\">\n";

    return $slct;

}

?>
