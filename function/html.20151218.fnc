<?php
/***********************************************************
 *
 * HTMLɽ���ؿ���
 *
 * �ѹ�����
 * 1.0.0 (2005/03/22) ��������(kajioka-h)
 *
 * @version     1.0.0 (2005/03/22)
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * 1.1.0 (2005/10/18) �ѹ�(suzuki-t)
 *
 * @version     1.1.0 (2005/10/18)
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 ***********************************************************/




/**
 * HTML�Υإå���ɽ��
 *
 * HTML�Υإå���ʬ��������ɽ������
 * HTML������HEAD��/HEAD������������
 *
 * �ѹ�����
 * 1.0.0 (2005/03/22) ��������(kajioka-h)
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/03/22)
 *
 * @param       string      $html_title     title������ǻ��Ѥ��륿���ȥ�
 * @param       string      $js             �ڡ������ɤ߹��೰��JavaScript�ե�����̾
 * @param       string      $css            �ڡ������ɤ߹��೰���������륷���ȥե�����̾
 *
 * @return      void
 *
 * @global      string      $g_html_charset �ڡ����˻��ꤹ��ʸ�������ɡ�config/config.php ��ǻ����
 * @global      string      $bgcolor        �ʤ���
 *
 */
function Html_Header($html_title="", $js="amenity.js", $css="global.css", $css2="") {

    $charset  = HTML_CHAR;
    $css_file = CSS_DIR ."$css";
    $js_file  = JS_DIR ."$js";
    $favicon  = IMAGE_DIR ."favicon.ico";

    if($css2 != ""){
        $css2 = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".CSS_DIR.$css2."\">";
    }

$html_header  =<<<PRINT_HTML_SRC
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=$charset">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <META HTTP-EQUIV="Imagetoolbar" CONTENT="no">
    <title>$html_title</title>
    <link rel="shortcut icon" href="$favicon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="$css_file">
    $css2
    <base target="_self">
</head>
<script language="javascript" src="$js_file">
</script>
PRINT_HTML_SRC;

    #echo "$html_header";
    return $html_header;

}

/**
 * HTML��BODY������ɽ��
 *
 * Html_Header�θ��ɽ������BODY������ɽ��
 *
 * �ѹ�����
 * 1.0.0 (2005/03/22) ��������(kajioka-h)
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/03/22)
 *
 * @param       string      $debug      BODY������ǻ��ꤹ��°�������
 *
 * @return      void
 *
 */
function Html_Body($debug="") {
    echo "\n\n<body $debug>\n\n";
    /*
    //�ǥХå�
    if($debug === 1){
        echo "<hr>\n";
        echo "<b>POST</b>\n";
        print_r ($_POST);
        echo "<hr>\n";
        echo "<b>GET</b>\n";
        print_r ($_GET);
    }else if ($debug === 2){
        echo "<pre>\n";
        echo "<b>POST</b>\n";
        print_r ($_POST);
        echo "<b>GET</b>\n";
        print_r ($_GET);
        echo "</pre>\n";
    }
    */

}

/**
 * HTML�Υեå���ɽ��
 *
 * �ڡ����κǸ�˥եå���ɽ��
 * ���ɽ���ơ��֥��/HTML����
 *
 * �ѹ�����
 * 1.0.0 (2005/03/22) ��������(kajioka-h)
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/03/22)
 *
 * @param       int     $debug      �ǥХå�ɽ���Υ��󡦥������ؤ�
 *                                  1�ޤ���2����ꤹ��ȥǥХå�ɽ����1��2��ɽ�������ΰ㤤�Τߡ�
 *
 * @return      void
 *
 */
function Html_Footer($debug = 0) 
{

$html_footer =<<<PRINT_HTML_SRC

<!--    <br>-->
    <!---------------------- �եå��ơ��֥볫�� --------------------->
    <table border="0" cellpadding="5" width="100%" height="0">
    <tr>
        <td>
            <div align="center">
            <font color="#585858" style="font-size: 12px;">
            Revision 1.6.0
            </div>
            </font>
        </td>
    </tr>
    <tr>
        <td>
            <div align="center">
            <font color="#585858" style="font-size: 12px;">
            Copyright &copy; 2007 Amenity Co.,Ltd. All Rights Reserved.
            </font>
            </div>
        </td>
    </tr>
    </table>
    <!--********************* �եå��ơ��֥뽪λ ******************-->
</form>
</body>
</html>
PRINT_HTML_SRC;

    #echo $html_footer;
    return $html_footer;

    /*
    //�ǥХå�
    if($debug === 1){
        echo "<hr>\n";
        echo "<b>POST</b>\n";
        print_r ($_POST);
        echo "<hr>\n";
        echo "<b>GET</b>\n";
        print_r ($_GET);
        echo "<hr>\n";
        echo "<b>SESSION</b>\n";
        print_r ($_SESSON);

    }else if ($debug === 2){
        echo "<pre>\n";
        echo "<b>POST</b>\n";
        print_r ($_POST);
        echo "<b>GET</b>\n";
        print_r ($_GET);
        echo "<b>SESSION</b>\n";
        print_r ($_SESSON);
        echo "</pre>\n";
    }
    */

}

//�ڡ���ɽ���ؿ��������,�ڡ�����,�ڡ����ץ�������̡�
function Html_Page($t_count,$p_count,$flg,$range,$width="100%")
{

    //ɽ�����������
    if($t_count == 0 || $t_count == 1){
        $html_page = <<<PRINT_HTML_SRC
            <!---------------------- �ڡ����ơ��֥볫�� --------------------->
            <table border="0" width=$width>
            <tr>
                <td width="50%" align="left">��<b>$t_count</b>��</td>
            </tr>
            </table>
            <!--********************* �ڡ����ơ��֥뽪λ ******************-->
PRINT_HTML_SRC;
    }else{
        //�ڡ���������
        if($t_count%$range == 0){
            $p_page = $t_count/$range;
        }else{
            $p_page = ((int)($t_count/$range))+1;
        }

        $select = "<select name=\"f_page".$flg."\" onChange=\"page_check(".$flg.")\">";

        //�ڡ�����ʬɽ��
        for($c=1;$c<=$p_page;$c++){
            if($p_count == $c)
            {
                $select .= "\n<option value=".$c." selected>".$c;
            }else{
                $select .= "\n<option value=".$c.">".$c;
            }
        }
        $select .= "\n</select>";

        //��롦�ʤ��󥯤�ɽ������ɽ��
        switch ($p_count){
            case 1:

            case null:
                $page = "<font color=\"#ABABAB\">���</font> | <a href=\"javascript:page_next(1)\">�ʤ�</a> | ";
    break;
            case $p_page:
                $page = "<a href=\"javascript:page_back(".$p_page.")\">���</a> | <font color=\"#ABABAB\">�ʤ�</font> | ";
    break;
            default:
                $page = "<a href=\"javascript:page_back(".$p_count.")\">���</a> | <a href=\"javascript:page_next(".$p_count.")\">�ʤ�</a> | ";
        }

        $apage_flg = ($t_count * $p_count <= $range) ? true : false;

        //�������Ƚ��
//        if($p_count == null){
        if($p_count == null || $apage_flg == true){
            //���������ɽ���ϰϰ���ξ�硢��롦�ʤࡦ�ץ���������ɽ��
            if($t_count <= $range){
                $page = null;
                $select = null;
                //�ϰϤ򣱡������
                $p_count_e = $t_count;
            }else{
                //�ϰϤ򣱡��ϰϿ�
                $p_count_e = $range;
            }
            $p_count_s = 1;
        }else{
            $p_count_s = $p_count*$range-($range-1);
            //�ڡ������ܻ��ˡ��ϰϿ�������������������硢������������ˤ���
            if($t_count < $p_count*$range){
                $p_count_e = $t_count;
            }else{
                $p_count_e = $p_count*$range;
            }
        }
            $html_page = <<<PRINT_HTML_SRC
            <!---------------------- �ڡ����ơ��֥볫�� --------------------->
            <table border="0" width=$width>
            <tr>
                <td width="50%" align="left">��<b>$t_count</b>����&nbsp;<b>$p_count_s</b>��<b>$p_count_e</b>ɽ��</td>
                <td width="50%" align="right">$page</td>
                <td width="50%" align="right">$select</td>
            </tr>
            </table>
            <!--********************* �ڡ����ơ��֥뽪λ ******************-->
PRINT_HTML_SRC;
    }
    return $html_page;
}


//�ڡ���ɽ���ؿ��������,�ڡ�����,�ڡ����ץ�������̡�
function Html_Page2($t_count, $p_count, $flg, $range, $width="100%")
{

    // ɽ�������0��ξ��
    if($t_count == 0 || $t_count == 1){

        // ������Τ�ɽ������ơ��֥�����
        $html_page = 
<<<PRINT_HTML_SRC
<table border="0" width="$width">
    <tr>
        <td width="50%" align="left">��<b>$t_count</b>��</td>
    </tr>
</table>
PRINT_HTML_SRC;

    // ɽ�������1��ʾ�ξ��
    }else{

        // �ڡ���������
        $p_page = ($t_count % $range == 0) ? $p_page = $t_count / $range : $p_page = ((int)($t_count / $range)) + 1;

        // �ڡ����ڤ��ؤ����쥯�ȥܥå�������
        $select = "\n<select name=\"f_page".$flg."\" onChange=\"page_check2(".$flg.", '".$_SERVER["PHP_SELF"]."')\">\n";
        // �ڡ�����ʬ�����ƥ����������򤵤줿�����ƥ��selected�ˤ����
        for($c = 1; $c <= $p_page; $c++){
            $select .= "    <option value=".$c." ".(($p_count == $c) ? "selected" : null).">".$c."</option>\n";
        }
        $select .= "</select>\n";

        // ��롦�ʤ��󥯤�ɽ������ɽ��
        switch ($p_count){
            case 1:

            case null:
                $page = "<font color=\"#ABABAB\">���</font> | <a href=\"javascript:page_next2(1, '".$_SERVER["PHP_SELF"]."')\">�ʤ�</a> | ";
                break;
            case $p_page:
                $page = "<a href=\"javascript:page_back2(".$p_page.", '".$_SERVER["PHP_SELF"]."')\">���</a> | <font color=\"#ABABAB\">�ʤ�</font> | ";
                break;
            default:
                $page = "<a href=\"javascript:page_back2(".$p_count.", '".$_SERVER["PHP_SELF"]."')\">���</a> | <a href=\"javascript:page_next2(".$p_count.", '".$_SERVER["PHP_SELF"]."')\">�ʤ�</a> | ";
        }

        $apage_flg = ($t_count * $p_count <= $range) ? true : false;

        // �������Ƚ��
        if($p_count == null || $apage_flg == true){

            //���������ɽ���ϰϰ���ξ�硢��롦�ʤࡦ�ץ���������ɽ��
            if ($t_count <= $range){
                $page = null;
                $select = null;
                // �ϰϤ򣱡������
                $p_count_e = $t_count;
            }else{
                // �ϰϤ򣱡��ϰϿ�
                $p_count_e = $range;
            }
            $p_count_s = 1;

        }else{

            $p_count_s = $p_count*$range-($range-1);
            //�ڡ������ܻ��ˡ��ϰϿ�������������������硢������������ˤ���
            if ($t_count < $p_count * $range){
                $p_count_e = $t_count;
            }else{
                $p_count_e = $p_count * $range;
            }

        }

        // �������󥯡��ץ�������ɽ������ơ��֥�����
        $html_page = 
<<<PRINT_HTML_SRC
<table border="0" width="$width">
    <tr>
        <td width="50%" align="left">��<b>$t_count</b>����&nbsp;<b>$p_count_s</b>��<b>$p_count_e</b>ɽ��</td>
        <td width="50%" align="right">$page</td>
        <td width="50%" align="right">$select</td>
    </tr>
    </table>
PRINT_HTML_SRC;

    }

    // ��������html����֤�
    return $html_page;

}



/*
function Code_value($which,$db_con,$jouken=""){
    if($which=="����"){
        $table = "t_goods";
        $which = "t_goods.goods_cd,t_goods.goods_name";
        $where = "goods";
    }else if($which=="�Ͷ�ʬ"){
        $table = "t_g_goods";
        $which = "g_goods_cd,g_goods_name";
        $where = "g_goods";
    }else if($which=="���ʶ�ʬ"){
        $table = "t_product";
        $which = "product_cd,product_name";
        $where = "product";
    }else if($which=="�϶�"){
        $table = "t_area";
        $which = "area_cd,area_name";
        $where = "area";
    }else if($which=="���"){
        $table = "t_bank";
        $which = "enter_cd,bank_name";
        $where = "bank";
    }else if($which=="�ȼ�"){
        $table = "t_btype";
        $which = "btype_cd,btype_name";
        $where = "business";
    }else if($which=="����"){
        $table = "t_part";
        $which = "part_cd,part_name";
        $where = "position";
    }else if($which=="�ܵҶ�ʬ"){
        $table = "t_rank";
        $which = "rank_cd,rank_name";
        $where = "client";
    }else if($which=="���롼��"){
        $table = "t_shop_gr";
        $which = "shop_gcd,shop_gname";
        $where = "group";
    }else if($which=="�����ȼ�"){
        $table = "t_trans";
        $which = "trans_cd,trans_name";
        $where = "forwarding";
    }else if($which=="�Ҹ�"){
        $table = "t_ware";
        $which = "ware_cd,ware_name";
        $where = "warehouse";
    }else if($which=="�����å�"){
        $table = "t_staff";
        $which = "staff_cd1,staff_cd2,staff_name";
        $where = "staff";
    }else if($which=="����"){
    $data .= "function close(code,place,num){\n";
    $data .= "  if(num != undefined){\n";
    $data .= "      var name = \"form_close\"+num+\"[name]\";\n";
    $data .= "  }else{\n";
    $data .= "      var name = \"form_close[name]\";\n";
    $data .= "  }\n";
    $data .= "  data = new Array(33);\n";
    $data .= "  len = code.value.length;\n";
    $data .= "  if(2==len && code.value>=1 && code.value<=30 && code.value!=null){\n";
    $data .= "      data[code.value]=\"�̾�����\";\n";
    $data .= "  }\n";
    $data .= "  data['31']=\"��������\";\n";
    $data .= "  data['91']=\"����������\";\n";
    $data .= "  data['99']=\"�������\";\n";
    $data .= "  var data = data[code.value];\n";
    $data .= "  if(data == undefined){\n";
    $data .= "      document.dateForm.elements[name].value = \"\";\n";
    $data .= "  }else{\n";
    $data .= "      document.dateForm.elements[name].value = data;\n";
    $data .= "  }\n";
    $data .= "}\n";
    return $data;
    }
    $data_sql = "select ".$which." from ".$table." ".$jouken.";";
    //SQL�¹�
    $result = pg_query($db_con,$data_sql);
    
    //SQL���顼Ƚ��
    if($result == false)
    {
        print "SQL���¹ԤǤ��ޤ���";
        exit;
    }
    $row = pg_num_rows($result);
    if($where=="staff"){
        $data .= "function $where(num){\n";
        $data .= "  if(num != undefined){\n";
        $data .= "      var name = \"form_staff\"+num+\"[name]\";\n";
        $data .= "      var code1 = \"form_staff\"+num+\"[code1]\";\n";
        $data .= "      var code2 = \"form_staff\"+num+\"[code2]\";\n";
        $data .= "  }else{\n";
        $data .= "      var name = \"form_staff[name]\";\n";
        $data .= "      var code1 = \"form_staff[code1]\";\n";
        $data .= "      var code2 = \"form_staff[code2]\";\n";
        $data .= "  }\n";
        $data .= "  len = document.dateForm.elements[code2].value.length;\n";
    }else{
        $data .= "function $where(code,place,search,num){\n";
        $data .= "  if(num != undefined && search == null){\n";
        $data .= "      var name = \"form_\"+place+num+\"[name]\";\n";
        $data .= "  }else if(search == undefined){\n";
        $data .= "      var name = \"form_\"+place+\"[name]\";\n";
        $data .= "  }else if(search != undefined && num == undefined){\n";
        $data .= "      var name = \"form_\"+place+\"\";\n";
        $data .= "  }else{\n";
        $data .= "      var name = \"t_\"+place+num;\n";
        $data .= "  }\n";
    }
    $data .= "          data = new Array($row);\n";
    
    if($where =="staff"){
        for($i=0;$i<$row;$i++)
        {
            //code1����
            $cd1 = pg_fetch_result($result,$i,0);
            //code2����
            $cd2 = pg_fetch_result($result,$i,1);
            //name����
            $name = pg_fetch_result($result,$i,2);
            $name = mb_ereg_replace('"','\"',$name);
            $data .= "  data[$cd1-$cd2]=\"$name\"\n";
        }
        $data .= "  var data = data[document.dateForm.elements[code1].value-document.dateForm.elements[code2].value];\n";
        $data .= "  if(len==3){\n";
        $data .= "      if(data == undefined){\n";
        $data .= "          document.dateForm.elements[name].value = \"\";\n";
        $data .= "      }else{\n";
        $data .= "          document.dateForm.elements[name].value = data; \n";
        $data .= "      }\n";
        $data .= "  }\n";
        $data .= "}\n";
    }else{
        for($i=0;$i<$row;$i++)
        {
            //code����
            $id = pg_fetch_result($result,$i,0);
            //name����
            $name = pg_fetch_result($result,$i,1);
            $name = mb_ereg_replace('"','\"',$name);
            $data .= "  data['$id']=\"$name\"\n";
        }
        $data .= "  var data = data[code.value];\n";
        $data .= "  if(data == undefined){\n";
        $data .= "      document.dateForm.elements[name].value = \"\";\n";
        $data .= "  }else{\n";
        $data .= "      document.dateForm.elements[name].value = data; \n";
        $data .= "  }\n";
        $data .= "}\n";
    }
    return $data;
}

*/
//<!--********************* �ʲ��ǿ��� ******************-->
function Code_value($table, $db_con, $jouken="", $type=""){

    // ���å����Υ���å�ID�����
    $shop_id    = $_SESSION["client_id"];

    // ���å����Υ��롼�׼��̤����
    $group_kind = $_SESSION["group_kind"];

    //�����
    if($jouken == null){
        $shop_id = $_SESSION["client_id"];
        $jouken  = " WHERE";
        $jouken .= "  shop_id = $shop_id";
    }

    $start = mb_substr($table,'2');

    //������ޥ��������ꤵ�줿���
    if($table == "t_client"){
        //������Υǡ��������
        if($type==2){
            $which = $start."_cd1,".$start."_cname";
        //������Υǡ��������
        }elseif($type == 1){
            $which = $start."_cd1,".$start."_cd2,".$start."_name";
        }elseif($type == 3){
            $which = $start."_cd1,".$start."_cd2, shop_name";
            $type = 1;
        }elseif($type == 4){
            $which = $start."_cd1, ".$start."_cd2, client_cname";
            $table  = " t_client";
            $table .= "     INNER JOIN";
            $table .= " t_claim";
            $table .= " ON t_client.client_id = t_claim.claim_id";
           
            $jouken  = " WHERE";
            $jouken .= "    t_claim.client_id = t_claim.claim_id";
            $jouken .= "    AND";
            $jouken .= "    t_client.client_div = '3'";
            $jouken .= "    AND";
            $jouken .= "    t_client.state = '1'";

            $type = 1;
        }elseif($type == 5){
/*
            $which = $start."_cd1, ".$start."_cd2, client_cname";
            $table  = " t_client";
            $table .= "     INNER JOIN";
            $table .= " t_client_info";
            $table .= " ON t_client.client_id = t_client_info.client_id";

            $jouken  = " WHERE";
            $jouken .= "    t_client_info.client_id = t_client_info.claim_id";
            $jouken .= "    AND";
            $jouken .= "    t_client.client_div = '1'";
            $jouken .= "    AND";
            $jouken .= "    t_client.state = '1'";
            $jouken .= "    AND";
            $jouken .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
*/
            $which  = $start."_cd1, ".$start."_cd2, client_cname";
            $table  = " (SELECT";
            $table .= "    claim_id";
            $table .= " FROM";
            $table .= "    t_claim";
            $table .= " ) AS t_claim";
            $table .= "    INNER JOIN";
            $table .= " t_client";
            $table .= " ON t_claim.claim_id = t_client.client_id";

            $table .= " AND t_client.shop_id = $shop_id";
            $jouken  = " WHERE";
            $jouken .= "    t_client.state = '1'";

            $type = 1;

        //FC����������Ǥ��褦
        }elseif($type == 6){
            $which  = $start."_cd1, ".$start."_cd2, client_cname";
            $table  = " t_client";
            $table .= "  INNER JOIN";
            $table .= " (SELECT";
            $table .= "     client_id";
            $table .= " FROM";
            $table .= "     t_claim";
            $table .= " WHERE";
            $table .= "     client_id IN (SELECT";
            $table .= "                     client_id";
            $table .= "                 FROM";
            $table .= "                     t_claim";
            $table .= "                 WHERE";
            $table .= "                     client_id = claim_id";
            $table .= "                 )";
            $table .= " GROUP BY client_id";
            $table .= " HAVING COUNT(client_id) = 1";
            $table .= " ) AS t_claim";
            $table .= " ON t_client.client_id = t_claim.client_id";

            $jouken  = " WHERE";
            $jouken .= "    t_client.client_div = '1'";
            $jouken .= "    AND";
            $jouken .= "    t_client.state = '1'";
            $jouken .= "    AND";
            $jouken .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";

            $type = 1;
        //FC���������ǻ���
        }elseif($type == 7){
            $which  = $start."_cd1, ".$start."_cd2, client_cname";
            $table = " (SELECT";
            $table .= "    claim_id";
            $table .= " FROM";
            $table .= "    t_claim";
            $table .= " ) AS t_claim";
            $table .= "    INNER JOIN";
            $table .= " t_client";
            $table .= " ON t_claim.claim_id = t_client.client_id";

            if($_SESSION[group_kind] == "2"){
                $table .= "     INNER JOIN\n";
                $table .= " t_client_info\n";
                $table .= " ON t_client.client_id = t_client_info.client_id";
                $table .= " AND t_client_info.cclient_shop = $shop_id";
            }else{
                $table .= " AND t_client.shop_id = $shop_id";
            }
            $jouken  = " WHERE";
            $jouken .= "    t_client.state = '1'";

            $type = 1;
        //�Ҳ������ǻ���(FC������ޥ���)
        }elseif($type == 8){
            $which   = "client_cd1,";
            $which  .= "CASE client_div ";
            $which  .= "     WHEN '2' THEN ''";
            $which  .= "     WHEN '3' THEN client_cd2 ";
            $which  .= "END AS client_cd2, ";
            $which  .= "client_name ";

            $table   = "t_client";

            $jouken  = " WHERE ";
            $jouken .= "client_div = '3' ";
            $jouken .= "OR ";
            $jouken .= "(client_div = '2' ";
            $jouken .= "AND ";
            $jouken .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
            $jouken .= ")";

        //�������ʥޥ����ǻ���
        }elseif($type == 9){
            $which = $start."_cd1,".$start."_cd2, client_cname";
            $type = 1;
        }
    }elseif($table == "t_goods" && $type == "1"){
        $which  = " t_goods.goods_cd,";
        $which .= " t_goods.goods_name";

        $jouken  = " WHERE";
        $jouken .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
        $jouken .= " AND";
        $jouken .= " t_goods_info.goods_id = t_goods.goods_id";

        $table  = "t_goods, t_goods_info";
    //��¤��
    }elseif($table == "t_goods" && $type == "2"){
        $which  = " t_goods.goods_cd,";
        $which .= " t_goods.goods_name";

        $jouken  = " WHERE";
        //$jouken .= "    t_goods.shop_gid = $_SESSION[shop_gid]";
        $jouken .= ($group_kind == "2") ? " t_goods.shop_id IN (".Rank_Sql().") " : " t_goods.shop_id = $shop_id ";
        $jouken .= "    AND";
        $jouken .= "    t_goods.public_flg = 't'";
        $jouken .= "    AND";
        $jouken .= "    t_goods.make_goods_flg = 't'";

    //����¾�Υơ��֥�򻲾Ȥ�����
    }else{
        $which = $table.".".$start."_cd, ".$table.".".$start."_name";
    }

    $where = $start;
    $data_sql = "select ".$which." from ".$table." ".$jouken.";";

    //SQL�¹�
    $result = Db_Query($db_con,$data_sql);
    
    //SQL���顼Ƚ��
    if($result == false)
    {
        print "SQL���¹ԤǤ��ޤ���";
        exit;
    }

    $row = pg_num_rows($result);

    if($where=="client" && ($type==1 || $type == 8)){
        $fnc_name = $where."1";
        $data .= "function $fnc_name(code1,code2,name){\n";
        $data .= "  data = new Array($row);\n";
        for($i=0;$i<$row;$i++)
        {
            //code1����
            $cd1 = pg_fetch_result($result,$i,0);
            //code2����
            $cd2 = pg_fetch_result($result,$i,1);
            //name����
            $name = pg_fetch_result($result,$i,2);
            $name = addslashes($name);
            //$name = mb_ereg_replace('"','\"',$name);
            $data .= "  data['$cd1-$cd2']=\"$name\";\n";
        }

        $data .= "    var data = data[document.dateForm.elements[code1].value+'-'+document.dateForm.elements[code2].value];\n";
//        $data .= "  var data = data[document.dateForm.elements[code1].value+document.dateForm.elements[code2].value];\n";
        $data .= "  len1 = document.dateForm.elements[code1].value.length;\n";
        $data .= "  len2 = document.dateForm.elements[code2].value.length;\n";
        $data .= "  if(data == undefined){\n";
        $data .= "      document.dateForm.elements[name].value = \"\";\n";
        $data .= "  }else if(len1 == 6 && len2 == 4){\n";
        $data .= "      document.dateForm.elements[name].value = data; \n";
        $data .= "  }\n";
        $data .= "}\n";

        return $data;

    }else{
        $data .= "function $where(code,name){\n";
        $data .= "  data = new Array($row);\n";
        for($i=0;$i<$row;$i++)
        {
            //code����
            $id = pg_fetch_result($result,$i,0);
            //name����
            $name = pg_fetch_result($result,$i,1);
            $name = addslashes($name);
            //$name = mb_ereg_replace('"','\"',$name);
            
            $data .= "  data['$id']=\"$name\"\n";
        }

        $data .= "  var data = data[code.value];\n";
        $data .= "  if(data == undefined){\n";
        $data .= "      document.dateForm.elements[name].value = \"\";\n";
        $data .= "  }else{\n";
        $data .= "      document.dateForm.elements[name].value = data; \n";
        $data .= "  }\n";
        $data .= "}\n";
        return $data;
    }
}


?>
