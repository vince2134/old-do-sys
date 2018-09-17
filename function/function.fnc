<?php
/**
 * @fileoverview ����˥ƥ����̴ؿ��ե�����
 *
 * ����¸�δؿ�̾�Ȥä�������
 * ���ե�����򳫤����ޤ�Υ�ʤ���������
 * �����顼��Ф����ޤ�Υ�ʤ���������
 * ���������Τʤ��ؿ��Ϥ��줾���PHP������ץ���ʤ⤷������js�ե�����ˤ�
 * ���ۤȤ�ɽ�����Ʊ���ʤΤˡ�2�Ȥ�3�Ȥ�̾����Ĥ��ƴؿ������䤷�ƥե������Ť����ʤ�
 *   �ʴؿ�¦���ѹ��ǺѤ���ϡ��ؿ�¦���б������
 * ���Ȥ�ʤ��ʤä��ؿ��Ͼä��ʥ����ȥ����Ȥ����
 * �����̤Υե�����˴ؿ����ɲä���Τʤ顢
 *   ����������ͤ��餤�ϤޤȤ��������񤭤ޤ��礦
 *                       ~~~~~~~
 *
 */


/**
 * ͹���ֹ椫��ǡ�������
 *
 * DB����͹���ֹ���б����뽻�ꡢ����եꥬ�ʤ������
 *
 * �ѹ�����
 * 1.0.0 (2005/12/07) ��������(watanabe-n)
 *
 * @author      watanabe-n <watanabe-n@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/12/07)
 *
 * @param               string      $post1      �ե���������Ϥ��줿͹���ֹ���3��
 * @param               string      $post2      �ե���������Ϥ��줿͹���ֹ��4��
 *
 * @return              array       $address_record
 *
 *
 */

function Post_Get($post1,$post2,$conn){
    $select_sql = "SELECT kana,ken,banchi";
    $select_sql .= " FROM t_post_no";
    $select_sql .= " WHERE post_no='$post1$post2'";
    $select_sql .= ";";
    $result = Db_Query($conn,$select_sql);
    $post_no = pg_num_rows($result);
    if($post_no==1){
        $address_record = pg_fetch_array($result);
    }else{
        $address_record = "";
    }
    return $address_record;
}



/**
 * ǯ��顢������������ɽ��
 *
 * �ѹ�����
 * 1.0.0 (2005/12/14) ��������(suzuki-t)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/12/14)
 *
 * @param               string      $year       �ե���������Ϥ��줿ǯ
 * @param               string      $month      �ե���������Ϥ��줿��
 * @param               string      $week       �ե���������Ϥ��줿��
 * @param               string      $day        �ե���������Ϥ��줿����
 *
 * @return              string      $display[$week]
 *
 *
 */

function Day_Get($year,$month,$week,$day){

    //�����ź����
    $x = 0;

    //ǯ�����
    $now = mktime(0, 0, 0, $month, 1, $year);
    //�������
    $dnum = date("t", $now);

    //�������ʬ
    for ($i=1;$i<=$dnum;$i++){
        $t = mktime(0, 0, 0, $month, $i, $year);
        $w = date("w", $t);
        //���ˤξ��ˤϡ�����˥ƥ��Υ����ɤ��ѹ�
        if($w==0){
            $w = 7;
        }
     
        //���Ϥ��줿���������
        if($day==$w){
            $display[$x] = $i;
            $x++;
        }
    }

    //ź����Ĵ��
    $week--;
    return $display[$week];
}

/**
 * ��������顢��������A��D���Τɤν����׻�����
 *
 * �ѹ�����
 * 1.0.0 (2005/12/26) ��������(suzuki-t)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/12/26)
 *
 * @param               string      $b_year     �ե���������Ϥ��줿����ǯ
 * @param               string      $b_month    �ե���������Ϥ��줿���η�
 * @param               string      $b_day      �ե���������Ϥ��줿������
 * @param               string      $year       �ե���������Ϥ��줿ǯ
 * @param               string      $month      �ե���������Ϥ��줿��
 * @param               string      $day        �ե���������Ϥ��줿��
 *
 * @return              string      $display
 *
 *
 */

function Basic_date($b_year,$b_month,$b_day,$year,$month,$day){

    //�����
    $now = mktime(0, 0, 0, $b_month, $b_day, $b_year);
    $date = date(U,$now) / 86400;
    //������
    $now = mktime(0, 0, 0, $month, $day, $year);
    $date2 = date(U,$now) / 86400;

    //���������������ޤǤ������׻�
    $basic = $date2 - $date;
    //������28����������
    $basic = $basic % 28;

    //A��Ƚ��
    if(0 <= $basic && $basic <= 6){
        //���β����ܤ�
        $basic++;
        $display[0] = 1;
        $display[1] = $basic;
    //B��Ƚ��   
    }else if(7 <= $basic && $basic <= 13){
        $basic = $basic - 6;
        $display[0] = 2;
        $display[1] = $basic;
    //C��Ƚ��   
    }else if(14 <= $basic && $basic <= 20){
        $basic = $basic - 13;
        $display[0] = 3;
        $display[1] = $basic;
    //D��Ƚ��   
    }else if(21 <= $basic && $basic <= 27){
        $basic = $basic - 20;
        $display[0] = 4;
        $display[1] = $basic;
    }else{
        $display = false;
    }

    return $display;
}


/**
 * Ģɼ�Υإå���ɽ���ؿ�
 *
 * �ѹ�����
 * 1.0.0 (2006/01/05) ��������(suzuki-t)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.0.0 (2006/01/05)
 *
 * @param               string      $pdf            PDF���֥�������
 * @param               string      $left_margin    ��եȥޡ�����
 * @param               string      $top_margin     �ȥåץޡ�����
 * @param               string      $title          �����ȥ�
 * @param               string      $left_top       ����Υإå�������̾
 * @param               string      $left_bottom    �����Υإå�������̾
 * @param               string      $right_top      ����Υإå�������̾
 * @param               string      $right_bottom   �����Υإå�������̾
 * @param               string      $page_count     �ڡ�����
 * @param               string      $list           ����̾
 * @param               string      $font_size      �ե���ȥ�����
 * @param               string      $page_size      �ڡ���������(A3:1110 A4:515)
 *
 */

function Header_disp($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_bottom,$right_bottom,$page_count,$list,$font_size,$page_size){

    $pdf->SetFont(GOTHIC, '', $font_size);
    $pdf->SetXY($left_margin,$top_margin);
    $pdf->Cell($page_size, 14, $title, '0', '1', 'C');
    $pdf->SetXY($left_margin,$top_margin);
    $pdf->Cell($page_size, 14, $page_count."�ڡ���", '0', '2', 'R');
    $pdf->SetX($left_margin);
    $pdf->Cell($page_size, 14, $left_top, '0', '1', 'L');
    $pdf->SetXY($left_margin,$top_margin+14);
    $pdf->Cell($page_size, 14, $right_top, '0', '1', 'R');
    $pdf->SetXY($left_margin,$top_margin+28);
    $pdf->Cell($page_size, 14, $right_bottom, '0', '1', 'R');
    $pdf->SetXY($left_margin,$top_margin+28);
    $pdf->Cell($page_size, 14, $left_bottom, '0', '2', 'L');

    //����ɽ��
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    for($i=0;$i<count($list)-1;$i++)
    {
        $pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
    }
    $pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

}


/**
 * ���쥯�ȥܥå������ͤ��������ؿ�
 *
 * �ѹ�����
 * 1.0.0 (2006/01/18) ��������(suzuki-t)
 * 1.1.0 (2006/01/24) ���ʶ�ʬ���Ͷ�ʬ�϶�ͭ�ե饰�Τ�Τ�ɽ������褦���ѹ�(kaji)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.1.0 (2006/01/24)
 *
 * @param               string      $db_con         DB�Υ��ͥ������
 * @param               string      $column         ���ꤷ��column̾
 *
 * @return              string      $select_value   ���ꤷ��Table���͡�0���ܡ�ID��1���ܡ�̾����
 *
 *
 */

function Select_Get($db_con,$column,$where="",$auth_flg=""){

    //�������̤�FC���̤�Ƚ��
    //FC�ξ�硢FC�ե饰��true�������ξ�硢false
    $fc_flg = $_SESSION["staff_flg"];

    //������Ƚ��
    if($where==""){
        //����
        if($column=="part"){
			if($_SESSION["group_kind"] == '2'){
			    $where = "WHERE shop_id IN (".Rank_Sql().") \n";
			}else{
			    $where = "WHERE shop_id = ".$_SESSION["client_id"];
			}
		//����
        }else if($column=="cal_part"){
		    $where = "WHERE shop_id = ".$_SESSION["client_id"];
        //�Ҹ�
        }else if($column=="ware"){
            if($_SESSION["group_kind"] == '2'){
                $where  = "WHERE shop_id IN (".Rank_Sql().") \n";
            }else{
                $where  = "WHERE shop_id = ".$_SESSION["client_id"];
            }
            $where .= " AND nondisp_flg = 'f'";
        //���
        }else if($column=="bank"){
            if($_SESSION["group_kind"] == '2'){
                $where  = "WHERE shop_id IN (".Rank_Sql().") \n";
            }else{
                $where  = "WHERE shop_id = ".$_SESSION["client_id"];
            }
        //���ʶ�ʬ
        }else if($column=="product"){
            //FC�ξ�硢��ͭ�ե饰��true�Τ�Τȼ����롼�פΤ�Τ�ɽ��
/*
            $where = "WHERE public_flg = true ";
            if($fc_flg != 't'){
                $where .= "OR shop_id = ".$_SESSION["client_id"];
            }
            $where .= " AND accept_flg = '1' ";
*/
            if($fc_flg != 't'){
                $where .= " WHERE (public_flg = 't' AND accept_flg = '1')";
                $where .= " OR";
                $where .= " shop_id = $_SESSION[client_id]";
            }else{
                $where .= " WHERE shop_id = $_SESSION[client_id]";
                $where .= " AND";
                $where .= " accept_flg = '1'";
            }

        //�о�
        }else if($column=="g_product"){
            //FC�ξ�硢��ͭ�ե饰��true�Τ�Τȼ����롼�פΤ�Τ�ɽ��
/*
            $where = "WHERE public_flg = true ";
            if($fc_flg != 't'){
                $where .= "OR shop_id = ".$_SESSION["client_id"];
            }
            $where .= "AND accept_flg = '1' ";
*/
            if($fc_flg != 't'){
                $where .= " WHERE (public_flg = 't' AND accept_flg = '1')";
                $where .= " OR";
                $where .= " shop_id = $_SESSION[client_id]";
            }else{
                $where .= " WHERE shop_id = $_SESSION[client_id]";
                $where .= " AND";
                $where .= " accept_flg = '1'";
            }
        //�Ͷ�ʬ
        }else if($column=="g_goods"){
            //FC�ξ�硢��ͭ�ե饰��true�Τ�Τȼ����롼�פΤ�Τ�ɽ��
/*
            $where  = "WHERE public_flg = true ";
            if($fc_flg != 't'){
                $where .= "OR shop_id = ".$_SESSION["client_id"];
            }
            $where .= "AND accept_flg = '1' ";
*/
            if($fc_flg != 't'){
                $where .= " WHERE (public_flg = 't' AND accept_flg = '1')";
                $where .= " OR";
                $where .= " shop_id = $_SESSION[client_id]";
            }else{
                $where .= " WHERE shop_id = $_SESSION[client_id]";
                $where .= " AND";
                $where .= " accept_flg = '1'";
            }
        //���ʥ��롼��
        }else if($column=="goods_gr"){
            //$where = "WHERE shop_id = ".$_SESSION["client_id"];
        //�϶�
        }else if($column=="area"){
            if($_SESSION["group_kind"] == '2'){
                $where = "WHERE shop_id IN (".Rank_Sql().")";
            }else{
                $where = "WHERE shop_id = ".$_SESSION["client_id"];
            }
        //ľ����
        }else if($column=="direct"){
//            $where = "WHERE shop_id = ".$_SESSION["client_id"];
            $where = "WHERE t_direct.shop_id = ".$_SESSION["client_id"];
        //������
        }else if($column=="compose"){
            $where = "WHERE shop_id = ".$_SESSION["client_id"];
        //�����ȼ�
        }else if($column=="trans"){
            $where = "WHERE shop_id = ".$_SESSION["client_id"];
        //�����ʬ(����)
        }else if($column=="trade_aord"){
            $where = "WHERE trade_id = '11' OR trade_id = '61'";
        //�����ʬ(���)
        }else if($column=="trade_sale"){
            $where = "WHERE kind = '1'";
        //�����ʬ�ʼ����򵯤����Ƥ�������
        }else if($column == "trade_sale_aord"){
            $where = "WHERE trade_id IN (11,15,61)";
            $column = "trade";
        //�����ʬ(����)
        }else if($column=="trade_payin"){
            $where = "WHERE kind = '2'";
        //�����ʬ(ȯ��)
        }else if($column=="trade_ord"){
            $where = "WHERE trade_id = '21' OR trade_id = '71'";
        //�����ʬ(����)
        }else if($column=="trade_buy"){
            $where = "WHERE kind = '3'";
        //�����ʬ��ȯ���򵯤����Ƥ��������
        }else if($column == "trade_buy_ord"){
            $where = "WHERE trade_id IN (21,25,71)";
            $column = "trade";
        //�����ʬ(��ʧ)
        }else if($column=="trade_payout"){
            $where = "WHERE kind = '4'";
        //�����å�
        }else if($column=="staff"){
//          $where = "WHERE shop_id = ".$_SESSION["client_id"];
            $where = "";
        //������
        }else if($column=="course"){
            $where = "WHERE shop_id = ".$_SESSION["client_id"];
        //�ܵҶ�ʬ
        }else if($column=="rank"){
            $where = "WHERE disp_flg = 't'";
        //��Ź OR �оݵ���
        }else if($column=="cshop"){
            $where = "WHERE ";
            $where .= " client_div = '3' ";
            $where .= " AND ";
            $where .= " shop_div = '2' ";

        //���Ƚ�
        }else if($column=="fcshop"){
            $where = "WHERE ";
            //$where .= " client_id IN (".Rank_Sql().")";
            $where .= " client_id = $_SESSION[client_id]";
            $where .= " AND ";
            $where .= " client_div = '3' ";
            $where .= " AND ";
            $where .= " (shop_div = '2' OR client_id = $_SESSION[client_id])";
/*
        //ľ�ĤΥ���å�
        }else if($column=="petition"){
            $where = "WHERE ";
            $where .= " attach_gid = ".$_SESSION["shop_gid"];
            $where .= " AND ";
            $where .= " shop_div = '1' ";
*/
        //ľ�ĤΥ���å�
        }else if($column=="dshop"){
            $where  = " WHERE ";
            $where .= "     t_client.client_div = '3' ";
            $where .= " AND ";
            $where .= "     t_rank.group_kind = '2' ";
        //FC�Υ���å�
        }else if($column=="fshop"){
            $where  = " WHERE ";
            $where .= "     t_client.client_div = '3' ";
            $where .= " AND ";
            $where .= "     t_rank.group_kind = '3' ";
		//FC�Υ���å�(�����Τ�)
        }else if($column=="calshop"){
            $where  = " WHERE ";
            $where .= "     t_client.client_div = '3' ";
            $where .= " AND ";
            $where .= "     t_rank.group_kind = '3' ";
            $where .= " AND ";
			$where .= "     t_client.state = '1' ";
        //FC��ľ�ĤΥ���å�
        }else if($column=="rshop"){
            $where  = " WHERE ";
            $where .= "     t_client.client_div = '3' ";
            $where .= " AND ";
            $where .= "     t_rank.group_kind IN ('2','3') ";
            $where .= " AND ";
			$where .= "     t_client.state = '1' ";
        //��ͭ����å�
        }else if($column=="own_shop"){
//            $where  = "WHERE";
//            $where .= " t_client.attach_gid = ".$_SESSION["shop_gid"];
//            $where .= " AND t_client.client_div = '3'";
            // ľ�Ĥξ��ϡ�ľ�Ĥ�FC�פΤ����
            if ($_SESSION["group_kind"] == "2"){
                $where .= " INNER JOIN t_rank ";
                $where .= " ON t_client.rank_cd = t_rank.rank_cd ";
                $where .= " WHERE ";
                $where .= " t_rank.group_kind = '2' ";
                $where .= " AND ";
            }else{
				$where .= "WHERE ";
			}
            $where .= " t_client.client_div = '3' ";
        //���������å�
        }elseif($column == "h_staff"){
            $where  = " WHERE";
            $where .= "     t_staff.staff_id = t_attach.staff_id";
            $where .= "     AND";
            $where .= "     t_attach.h_staff_flg = 't'";
        }elseif($column == "pattern"){
            $where  = " WHERE";
            if($_SESSION["group_kind"] == "2"){
                $where .= "    shop_id IN (".Rank_Sql().")";
            }else{
                $where .= "     shop_id = ".$_SESSION["client_id"];
            }
        }elseif($column == "claim_pattern"){
            $where  = " WHERE";
            if($_SESSION["group_kind"] == "2"){
                $where .= "    shop_id IN (".Rank_Sql().")";
            }else{
                $where .= "     shop_id = ".$_SESSION["client_id"];
            }
        }

    }

    //�ͼ���Ƚ��
    switch ($column){
        case 'divide':
            //�����ʬ(��key���ͤ��ѹ����ʤ��ǲ���������)
            $select_value = array(
                ""  =>  "",
                "01"  =>  "01 �� ��ԡ���",
                "02"  =>  "02 �� ����",
                "03"  =>  "03 �� ��󥿥�",
                "04"  =>  "04 �� �꡼��",
                //"05"  =>  "05 �� ��",
                "05"  =>  "05 �� ����",
                "06"  =>  "06 �� ����¾",
                //"08"  =>  "08 �� �ݸ�",
                //"09"  =>  "09 �� �ֵ�",
                //"10"  =>  "10 �� ���",
            );
            break;
		case 'divide_con':
            //����������ʬ(��key���ͤ��ѹ����ʤ��ǲ���������)
            $select_value = array(
                ""  =>  "",
                "01"  =>  "��ԡ���",
                "02"  =>  "����",
                "03"  =>  "��󥿥�",
                "04"  =>  "�꡼��",
                //"05"  =>  "05 �� ��",
                "05"  =>  "����",
                "06"  =>  "����¾",
                //"08"  =>  "08 �� �ݸ�",
                //"09"  =>  "09 �� �ֵ�",
                //"10"  =>  "���",
            );
            break;
        case 'trade_aord':
        case 'trade_sale':
        case 'trade_payin':
        case 'trade_ord':
        case 'trade_buy':
        case 'trade_payout':
            //�����ʬ(��������塦���⡦ȯ������������ʧ)
            $sql = "SELECT trade_id,trade_cd, trade_name ";
            $sql .= "FROM t_trade ";
            $sql = $sql.$where;
            $sql .= " ORDER BY trade_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;
        case 'close':
            //����
            $select_value[""] = "";
            for($x=1;$x<=28;$x++){
                $select_value[$x] = $x."��";
            }
            $select_value["29"] = "����";

            break;
/*
        case 'close2':
            //����
            $select_value[""] = "";
            for($x=1;$x<=28;$x++){
                if($x>=29){
                    $g_form_option_select .= " style=\"color:RED;\"";
                }
                $select_value[$x] = $x."��";
            }
            $select_value["31"] = "31��(����)";
            $select_value["91"] = "����";
            break;
*/
        case 'cshop':
            //��Ź OR �оݵ���
            $sql = "SELECT client_id,client_cd1,client_cd2,client_name ";
            $sql .= "FROM t_client ";
            $sql = $sql.$where;
            $sql .= " ORDER BY client_cd1,client_cd2";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = @pg_fetch_array($result)){
                    $data_list[0] = htmlspecialchars($data_list[0]);
                    $data_list[1] = htmlspecialchars($data_list[1]);
                    $data_list[2] = htmlspecialchars($data_list[2]);
                    $data_list[3] = htmlspecialchars($data_list[3]);
                   $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." �� ".$data_list[3];
            }
            break;
        case 'petition':
            //�ܼ�
            $sql = "SELECT client_id,client_cd1,client_cd2,client_name ";
            $sql .= "FROM t_client ";
            $sql = $sql.$where;
            $sql .= " ORDER BY client_cd1,client_cd2";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                    $data_list[0] = htmlspecialchars($data_list[0]);
                    $data_list[1] = htmlspecialchars($data_list[1]);
                    $data_list[2] = htmlspecialchars($data_list[2]);
                    $data_list[3] = htmlspecialchars($data_list[3]);
                   $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." �� ".$data_list[3];
            }
            break;
        case 'fcshop':
            //���Ƚ�
            $sql = "SELECT client_id,client_cd1,client_cd2,client_cname ";
            $sql .= "FROM t_client ";
            $sql = $sql.$where;
            $sql .= " ORDER BY client_cd1,client_cd2";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            while($data_list = pg_fetch_array($result)){
                    $data_list[0] = htmlspecialchars($data_list[0]);
                    $data_list[1] = htmlspecialchars($data_list[1]);
                    $data_list[2] = htmlspecialchars($data_list[2]);
                    $data_list[3] = htmlspecialchars($data_list[3]);
                   $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." �� ".$data_list[3];
            }
            break;
        case 'dshop':
        case 'fshop':
        case 'calshop':
        case 'rshop':
            //ľ�ĤΥ���å�
            //FC�Υ���å�
            $sql  = "SELECT ";
            $sql .= "    t_client.client_id,";
            $sql .= "    t_client.client_cd1,";
            $sql .= "    t_client.client_cd2,";
            $sql .= "    t_client.client_cname ";
            $sql .= "FROM ";
            $sql .= "    t_client ";
            $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd ";
            $sql  = $sql.$where;
            $sql .= " ORDER BY client_cd1,client_cd2";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                    $data_list[0] = htmlspecialchars($data_list[0]);
                    $data_list[1] = htmlspecialchars($data_list[1]);
                    $data_list[2] = htmlspecialchars($data_list[2]);
                    $data_list[3] = htmlspecialchars($data_list[3]);
                   $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." �� ".$data_list[3];
            }
            break;
        case 'staff':
            //ô����
            if ($auth_flg == true){
                // �ڡ���̾�򸢸¥ޥ��������̾���Ѵ�
                $page_name   = substr($_SERVER[PHP_SELF], strrpos($_SERVER[PHP_SELF], "/")+1);
                $module_name = substr($page_name, 0,  strpos($page_name, "."));
                $column_name = str_replace("-", "_", substr_replace($module_name, substr($module_name, 0, 1) == "1" ? "h" : "f", 0, 1));
                // FROM��˸��¥ơ��֥��Ϣ��
                $join_sql =  " INNER JOIN t_permit ON t_staff.staff_id = t_permit.staff_id ";
                // WHERE����ɲä�����
//                $where_sql = " AND t_permit.$column_name = 't' ";
                $where_sql = " AND t_permit.$column_name = 'w' ";
            }

            $sql = "SELECT t_staff.".$column."_id, t_staff.charge_cd, t_staff.".$column."_name ";
            $sql .= "FROM t_".$column." INNER JOIN t_attach ";
            $sql .= " ON t_staff.staff_id = t_attach.staff_id ";
            $sql .= ($auth_flg == true) ? $join_sql : null;
            $sql .= "WHERE";
            $sql .= "   t_staff.state = '�߿���'";
            $sql .= ($auth_flg == true) ? $where_sql : null;
            $sql .= " AND";
            //ľ�Ĥξ��
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_attach.shop_id IN (".Rank_Sql().")";
            }else{
                $sql .= "   t_attach.shop_id = $_SESSION[client_id]";
            }
            $sql .= " ORDER BY t_staff.charge_cd";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;

        case 'cstaff':
            //ô����
            $sql = "SELECT t_staff.staff_id,t_staff.charge_cd,t_staff.staff_name ";
            $sql .= "FROM t_staff ";
            $sql .= "    INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id ";
            $sql .= "WHERE";
            //������ޥ����Ǥ��࿦���ɽ��
            if($auth_flg != '1'){
                $sql .= "   t_staff.state = '�߿���' ";
                $sql .= "AND ";
            }

            //ľ�Ĥξ��
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_attach.shop_id IN (".Rank_Sql().")";
            //ľ�İʳ�
            }else{
                $sql .= "   t_attach.shop_id = ".$_SESSION[client_id];
            }
            $sql .= " ORDER BY charge_cd";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;

		case 'cal_staff':
            //ô����
            $sql = "SELECT t_staff.staff_id,t_staff.charge_cd,t_staff.staff_name ";
            $sql .= "FROM t_staff ";
            $sql .= "    INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id ";
            $sql .= "WHERE";
            //������ޥ����Ǥ��࿦���ɽ��
            if($auth_flg != '1'){
                $sql .= "   t_staff.state = '�߿���' ";
                $sql .= "AND ";
            }
            $sql .= "   t_attach.shop_id = ".$_SESSION[client_id];
            $sql .= " ORDER BY charge_cd";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;

        case 'h_staff':
            //���������å�
            $sql  = "SELECT t_staff.staff_id, t_staff.charge_cd, t_staff.staff_name";
            $sql .= " FROM t_attach, t_staff";
            $sql .=  $where;
            $sql .= "   ORDER BY t_staff.charge_cd";
            $sql .= ";";
            break;
		case 'sale_staff':
			//�����ɼ�Ǥϡ�value�ͤ�ô����CD����Ѥ���

            //ô����
            $sql = "SELECT t_staff.charge_cd,t_staff.staff_name ";
            $sql .= "FROM t_staff ";
            $sql .= "    INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id ";
            $sql .= "WHERE";
            //ľ�Ĥξ��
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_attach.shop_id IN (".Rank_Sql().")";
            //ľ�İʳ�
            }else{
                $sql .= "   t_attach.shop_id = ".$_SESSION[client_id];
            }
            $sql .= " ORDER BY charge_cd";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[0] = str_pad($data_list[0], 4, 0, STR_POS_LEFT);
                $select_value[$data_list[0]] = $data_list[0]." �� ".$data_list[1];
            }
            break;

        case "shop_staff":
            // ����åפ˽�°���륹���å�
            $sql  = "SELECT t_attach.staff_id, t_staff.charge_cd, t_staff.staff_name ";
            $sql .= "FROM t_attach ";
            $sql .= "INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "WHERE ";
            //ľ�Ĥξ��
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_attach.shop_id IN (".Rank_Sql().")";
            //ľ�İʳ�
            }else{
                $sql .= "   t_attach.shop_id = ".$_SESSION[client_id];
            }
            $sql .= " ORDER BY charge_cd";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;

        case "round_staff_m":
            // ���ô���ԡʥ����åեޥ������������
            $sql  = "SELECT \n";
            $sql .= "    t_round_staff.staff_id, \n";
            $sql .= "    LPAD(t_staff.charge_cd, 4, '0') AS charge_cd, \n";
            $sql .= "    t_staff.staff_name \n";
            $sql .= "FROM \n";
            $sql .= "    ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            t_attach.staff_id \n";
            $sql .= "        FROM \n";
            $sql .= "            t_attach \n";
            $sql .= "            LEFT JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
            $sql .= "        WHERE \n";
            $sql .= "            t_staff.state = '�߿���' \n";
            $sql .= "        AND \n";
            $sql .= "            t_staff.round_staff_flg = 't' \n";
            $sql .= "        AND \n";
            $sql .= "            t_attach.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "    ) \n";
            $sql .= "    AS t_round_staff \n";
            $sql .= "    LEFT JOIN t_staff ON t_round_staff.staff_id = t_staff.staff_id \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_staff.charge_cd \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $Select_Value[""] = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($res)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;

        case "round_staff_ms":
            // ���ô���ԡʥ����åեޥ����������ɼ���������
            $sql  = "SELECT \n";
            $sql .= "    t_round_staff.staff_id, \n";
            $sql .= "    LPAD(t_staff.charge_cd, 4, '0') AS charge_cd, \n";
            $sql .= "    t_staff.staff_name \n";
            $sql .= "FROM \n";
            $sql .= "    ( \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                t_attach.staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_attach \n";
            $sql .= "                LEFT JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_staff.state = '�߿���' \n";
            $sql .= "            AND \n";
            $sql .= "                t_staff.round_staff_flg = 't' \n";
            $sql .= "            AND \n";
            $sql .= "                t_attach.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_sale_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_sale_h \n";
            $sql .= "                LEFT JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_sale_h.contract_div = '1' \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_h.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_sale_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_sale_h \n";
            $sql .= "                LEFT JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_sale_h.contract_div = '2' \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_h.act_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_aorder_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_aorder_h \n";
            $sql .= "                LEFT JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_aorder_h.contract_div = '1' \n";
            $sql .= "            AND \n";
            $sql .= "                t_aorder_h.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_aorder_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_aorder_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_aorder_h \n";
            $sql .= "                LEFT JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_aorder_h.contract_div = '2' \n";
            $sql .= "            AND \n";
            $sql .= "                t_aorder_h.act_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_aorder_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "    ) \n";
            $sql .= "    AS t_round_staff \n";
            $sql .= "    LEFT JOIN t_staff ON t_round_staff.staff_id = t_staff.staff_id \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_staff.charge_cd \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $Select_Value[""] = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($res)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;

        case "round_staff_ms_cd":
            // ���ô���ԡʥ����åեޥ����������ɼ���������
            $sql  = "SELECT \n";
            $sql .= "    t_round_staff.staff_id, \n";
            $sql .= "    LPAD(t_staff.charge_cd, 4, '0') AS charge_cd, \n";
            $sql .= "    t_staff.staff_name \n";
            $sql .= "FROM \n";
            $sql .= "    ( \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                t_attach.staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_attach \n";
            $sql .= "                LEFT JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_staff.state = '�߿���' \n";
            $sql .= "            AND \n";
            $sql .= "                t_staff.round_staff_flg = 't' \n";
            $sql .= "            AND \n";
            $sql .= "                t_attach.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_sale_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_sale_h \n";
            $sql .= "                LEFT JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_sale_h.contract_div = '2' \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_h.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "    ) \n";
            $sql .= "    AS t_round_staff \n";
            $sql .= "    LEFT JOIN t_staff ON t_round_staff.staff_id = t_staff.staff_id \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_staff.charge_cd \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $Select_Value[""] = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($res)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[1]] = $data_list[1]." �� ".$data_list[2];
            }
            break;

        case "claim":
            // ������
            $sql  = "SELECT t_claim.claim_div, t_client.client_cname ";
            $sql .= "FROM t_claim ";
            $sql .= "INNER JOIN t_client ON t_claim.claim_id = t_client.client_id ";
            $sql .= "WHERE ";
            $sql .= ($where != null) ? " $where AND " : null;
            //ľ�Ĥξ��
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_client.shop_id IN (".Rank_Sql().")";
            //ľ�İʳ�
            }else{
                $sql .= "   t_client.shop_id = ".$_SESSION[client_id];
            }
            $sql .= "ORDER BY t_claim.client_id, t_claim.claim_id, t_claim.claim_div ";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;


        case "claim_payin":
            // ������
            $sql  = "SELECT t_claim.claim_div, t_client.client_cname ";
            $sql .= "FROM t_claim ";
            $sql .= "INNER JOIN t_client ON t_claim.claim_id = t_client.client_id ";
            $sql .= "WHERE ";
            $sql .= ($where != null) ? " $where AND " : null;
            //ľ�Ĥξ��
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_client.shop_id IN (".Rank_Sql().")";
            //ľ�İʳ�
            }else{
                $sql .= "   t_client.shop_id = ".$_SESSION[client_id];
            }
            $sql .= "ORDER BY t_claim.claim_div ";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;


        case 'bank':
            //���
            $sql  = "SELECT ".$column."_id, bank_cd,".$column."_name ";
            $sql .= "FROM t_".$column." ";
//            $sql .= "WHERE ";
//            $sql .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
            $sql .= $where;
            $sql .= " ORDER BY bank_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;

        case 'b_bank2':
            //��Ի�Ź
            $sql  = "SELECT t_b_bank.b_bank_id, t_b_bank.b_bank_cd, t_b_bank.b_bank_name ";
            $sql .= "FROM t_b_bank ";
            $sql .= "INNER JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
            $sql .= "WHERE ";
            $sql .= ($_SESSION["group_kind"] == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = ".$_SESSION["client_id"]." ";
            $sql .= $where;
            $sql .= "ORDER BY t_b_bank.b_bank_cd ";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;

/*
        case 'bank_b_bank':
            // ��ԡ���Ź
            $sql  = "SELECT ";
            $sql .= "   t_b_bank.b_bank_id, ";
            $sql .= "   t_bank.bank_cd, ";
            $sql .= "   t_bank.bank_name, ";
            $sql .= "   t_b_bank.b_bank_cd, ";
            $sql .= "   t_b_bank.b_bank_name ";
            $sql .= "FROM ";
            $sql .= "   t_b_bank ";
            $sql .= "   LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
            $sql .= "ORDER BY ";
            $sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd ";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            $select_value = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $space = "";
                for($i = 0; $i< $max_len; $i++){
                    if(mb_strwidth($data_list[2]) <= $max_len && $i != 0){
                            $data_list[2] = $data_list[2]."��";
                    }
                }
                
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2]."���� ".$data_list[3]." �� ".$data_list[4];
            }
            break;
*/

        case 'goods_gr':
            //���ʥ��롼��
            $sql = "SELECT DISTINCT goods_gid,goods_gname ";
            $sql .= "FROM t_".$column." ";
            $sql = $sql.$where;
            $sql .= " ORDER BY goods_gname";
            $sql .= ";";
        
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;
        case 'compose':
        case 'make_goods':
            //������ OR ��¤��
            $sql = "SELECT t_goods.goods_id,t_goods.goods_cd,t_goods.goods_name ";
            $sql .= "FROM t_goods,t_".$column." ";
            $sql = $sql.$where;
            $sql .= " ORDER BY t_goods.goods_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;
        case 'rank':
            //�ܵҶ�ʬ
            $sql = "SELECT ".$column."_cd,".$column."_name ";
            $sql .= "FROM t_".$column." ";
            $sql = $sql.$where;
            $sql .= " ORDER BY ".$column."_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[0]." �� ".$data_list[1];
            }
            break;
        case 'own_shop':
            //��ͭ����å�
            $sql  = "SELECT";
            $sql .= "   t_client.client_id,";
            $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,";
            $sql .= "   t_client.client_cname";
            $sql .= " FROM";
            $sql .= "   t_client ";
            $sql .= $where;
            $sql .= " ORDER BY t_client.client_cd1, t_client.client_cd2";

            $result = Db_Query($db_con, $sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." : ".$data_list[2];
            }
            break;
        case 'btype':
            //�ȼ�
            $sql  = "SELECT";
            $sql .= "   t_lbtype.lbtype_cd,";
            $sql .= "   t_lbtype.lbtype_name,";
            $sql .= "   t_sbtype.sbtype_id,";
            $sql .= "   t_sbtype.sbtype_cd,";
            $sql .= "   t_sbtype.sbtype_name";
            $sql .= " FROM";
            $sql .= "   t_lbtype";
            $sql .= "       INNER JOIN";
            $sql .= "   t_sbtype";
            $sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
            $sql .= " WHERE t_sbtype.accept_flg = 't' ";
            $sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);

            while($data_list = pg_fetch_array($result)){
                if($max_len < mb_strwidth($data_list[1])){
                    $max_len = mb_strwidth($data_list[1]);
                }
            }

            $result = Db_Query($db_con, $sql);
            $select_value = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $space = "";
                for($i = 0; $i< $max_len; $i++){
                    if(mb_strwidth($data_list[1]) <= $max_len && $i != 0){
                            $data_list[1] = $data_list[1]."��";
                    }
                }
                
                $select_value[$data_list[2]] = $data_list[0]." �� ".$data_list[1]."���� ".$data_list[3]." �� ".$data_list[4];
            }
            break;
        case 'h_area':
            $sql = "SELECT area_id,area_cd,area_name ";
            $sql .= "FROM t_area ";
            $sql .= " WHERE shop_id = $_SESSION[client_id] ";
            $sql .= " ORDER BY area_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;
        case 'b_bank':
            $sql  = "SELECT";
            $sql .= "   t_bank.bank_id,";
            $sql .= "   t_b_bank.b_bank_id,";
            $sql .= "   t_b_bank.b_bank_cd,";
            $sql .= "   t_b_bank.b_bank_name";
            $sql .= " FROM";
            $sql .= "    t_bank";
            $sql .= " LEFT JOIN";
            $sql .= "   t_b_bank";
            $sql .= "   ON t_bank.bank_id = t_b_bank.bank_id";
            $sql .= $where;
            $sql .= " ORDER BY t_bank.bank_cd, t_b_bank.b_bank_cd";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);

            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $data_list[3] = htmlspecialchars($data_list[3]);
                $select_value[$data_list[0]][$data_list[1]] = $data_list[2]." �� ".$data_list[3];
            }
            break;
/*
        case 'shop_gr':
            //FC���롼��
            $sql = "SELECT shop_gid, shop_gcd, shop_gname";
            $sql .= " FROM t_shop_gr";
            $sql .= " ORDER BY shop_gcd";
            $select_value[""] = "";

            $result = Db_Query($db_con, $sql);
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]."������".$data_list[2];
            }
            break;
*/
        case 'pattern':
            //�ѥ�����
            $sql = "SELECT s_pattern_id, s_pattern_no, s_pattern_name ";
            $sql .= "FROM t_slip_sheet ";
            $sql = $sql.$where;
            $sql .= " ORDER BY s_pattern_no";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;
        case 'claim_pattern':
            //�ѥ�����
            $sql = "SELECT c_pattern_id,c_pattern_name ";
            $sql .= "FROM t_claim_sheet ";
            $sql = $sql.$where;
            $sql .= " ORDER BY c_pattern_id";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;
        case 'pay_way':
            //������ˡ
            $select_value[""]   = null;
            $select_value["1"]  = "1 �� ��ư����";
            $select_value["2"]  = "2 �� ����"; 
            $select_value["3"]  = "3 �� ˬ�佸��";
            $select_value["4"]  = "4 �� ���";
            $select_value["5"]  = "5 �� ����¾";
            break;
        case 'trans';
            //�����ȼ�
            $sql  = "SELECT trans_id, trans_cd, trans_cname ";
            $sql .= "FROM t_trans ";
            $sql .= "$where ";
            $sql .= "ORDER by trans_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]."������".$data_list[2];
            }
            break;
        case 'direct';
/*
            //�����ȼ�
            $sql  = "SELECT direct_id, direct_cd, direct_cname ";
            $sql .= "FROM t_direct ";
            $sql .= "$where ";
            $sql .= "ORDER by direct_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]."������".$data_list[2];
            }
            break;
*/
            //ľ����
            $sql  = "SELECT direct_id, direct_cd, direct_cname, t_client.client_cname ";
            $sql .= "FROM t_direct LEFT JOIN t_client ON t_direct.client_id = t_client.client_id ";
            $sql .= "$where ";
            $sql .= "ORDER by direct_cd";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            while($data_list = pg_fetch_array($result)){
                if($max_len < mb_strwidth($data_list[2])){
                    $max_len = mb_strwidth($data_list[2]);
                }
            }

            $result = Db_Query($db_con, $sql);
            $select_value       = "";   
            $select_value[""]   = "";   
            while($data_list = pg_fetch_array($result)){
                $space = "";
                for($i = 0; $i< $max_len; $i++){
                    if(mb_strwidth($data_list[2]) <= $max_len && $i != 0){
                        $data_list[2] = $data_list[2]."��";
                    }       
                }
    
            $select_value[$data_list[0]]  = htmlspecialchars($data_list[1]);
            $select_value[$data_list[0]] .= " : ";
            $select_value[$data_list[0]] .= htmlspecialchars($data_list[2]);
            $select_value[$data_list[0]] .= "������ : ";
            $select_value[$data_list[0]] .= htmlspecialchars($data_list[3]);
            }

            break;

		case 'serv_con':
			//����Υ����ӥ�
            $sql = "SELECT serv_id,serv_cd,serv_name ";
            $sql .= "FROM t_serv ";
            $sql = $sql.$where;
            $sql .= " ORDER BY serv_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[2];
            }
			break;
		case 'cal_part':
            $sql = "SELECT part_id,part_cd,part_name ";
            $sql .= "FROM t_part ";
            $sql = $sql.$where;
            $sql .= " ORDER BY part_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
			break;
        case 'course':
            $sql  = "SELECT course_id, course_name ";
            $sql .= "FROM t_course ";
            $sql .= $where;
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;
        case 'client_gr':
            $sql  = "SELECT client_gr_id, client_gr_cd, client_gr_name ";
            $sql .= "FROM t_client_gr ";
            $sql .= "WHERE ";
            if($_SESSION["group_kind"] == "2"){
                $sql .= "    shop_id IN (".Rank_Sql().")";
            }else{
                $sql .= "     shop_id = ".$_SESSION["client_id"];
            }
            $sql .= " ORDER BY client_gr_cd ";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }       
            break;  
        case 'branch':
            //��Ź
            $sql  = "SELECT branch_id, branch_cd, branch_name ";
            $sql .= "FROM t_branch ";
            $sql .= "WHERE ";
            $sql .= " shop_id = ".$_SESSION["client_id"]." ";
            $sql .= " ORDER BY branch_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;
        case 'ware':
            //�Ҹ�
            $sql  = "SELECT ware_id, ware_cd, ware_name ";
            $sql .= "FROM t_ware ";
            $sql .= " $where ";
            $sql .= " ORDER BY staff_ware_flg, ware_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
            break;
        default:
            $sql = "SELECT ".$column."_id,".$column."_cd,".$column."_name ";
            $sql .= "FROM t_".$column." ";
            $sql = $sql.$where;
            $sql .= " ORDER BY ".$column."_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
            }
    }

    return $select_value;
//  return $g_form_option_select;
}

/**
 * ��������Ͽ
 *
 * �ѹ�����
 * 1.0.0 (2005/01/28) ��������(suzuki-t)
 * 1.1.0 (2006/03/15) shop_id��client_id���ѹ�(suzuki-t)
 * 1.2.0 (2007/03/28) �����å�̾�ȥǡ���ID����Ͽ����褦�˽���(morita-d)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.1.0 (2006/03/15)
 *
 * @param               string      $db_con         DB�Υ��ͥ������
 * @param               string      $mst_name       �ޥ���̾
 * @param               string      $work_div       ��ȶ�ʬ
 * @param               string      $data_cd        �ǡ���������
 * @param               string      $data_name      �ǡ��������ɤ�̾��
 * @param               int         $data_name      �ǡ���ID��̾��
 *
 * @return              string      $display[$week]
 *
 *
 */

function Log_Save($db_con,$mst_name,$work_div,$data_cd,$data_name,$data_id=-1){

    //ô����ID������å�ID����
    $staff_id   = $_SESSION["staff_id"];
    $client_id  = $_SESSION["client_id"];
    $staff_name = addslashes($_SESSION["staff_name"]);   //���������̾

    $mst_name = "t_".$mst_name;
    $pkey = Get_Pkey();

    $table["t_part"]            = "����ޥ���";
    $table["t_ware"]            = "�Ҹ˥ޥ���";
    $table["t_area"]            = "�϶�ޥ���";
    $table["t_lbtype"]          = "�ȼ�ޥ����ʣͶ�ʬ��";
    $table["t_sbtype"]          = "�ȼ�ޥ����ʾ�ʬ���";
    $table["t_serv"]            = "�����ӥ��ޥ���";
    $table["t_course"]          = "�������ޥ���";
    $table["t_client"]          = "������ޥ���";
    $table["t_shop"]            = "FC�������ޥ���";
    $table["t_staff"]           = "�����åեޥ���";
    $table["t_goods"]           = "���ʥޥ���";
    $table["t_g_goods"]         = "�Ͷ�ʬ�ޥ���";
    $table["t_product"]         = "������ʬ�ޥ���";      
    $table["t_g_product"]       = "����ʬ��ޥ���";        
    $table["t_make_goods"]      = "��¤�ʥޥ���";
    $table["t_compose"]         = "�����ʥޥ���";
    $table["t_shop_gr"]         = "FC���롼�ץޥ���";
    $table["t_rank"]            = "FC��������ʬ�ޥ���";
    $table["t_bank"]            = "��ԥޥ���";
    $table["t_b_bank"]          = "��Ի�Ź�ޥ���";
    $table["t_account"]         = "���¥ޥ���";
    $table["t_trans"]           = "�����ȼԥޥ���";
    $table["t_direct"]          = "ľ����ޥ���";
    $table["t_contract"]        = "����ޥ���";
    $table["t_bstruct"]         = "���֥ޥ���";
    $table["t_inst"]            = "���ߥޥ���";
    $table["t_supplier"]        = "������ޥ���";
    $table["t_gr"]              = "���롼�ץޥ���";

    //��������Ͽ
    $sql  = "INSERT INTO ";
    $sql .= "t_mst_log ";
    $sql .= "(";
    $sql .= "log_id,";
    $sql .= "staff_id,";
    $sql .= "staff_name,";
    $sql .= "mst_name,";
    $sql .= "work_div,";
    $sql .= "data_id,";
    $sql .= "data_cd,";
    $sql .= "data_name,";
    $sql .= "shop_id ";
    $sql .= ")VALUES(";
    $sql .= "$pkey, ";
    $sql .= "$staff_id,";
    $sql .= "'$staff_name',";
    $sql .= "'$table[$mst_name]',";
    $sql .= "'$work_div',";
    $sql .= "$data_id,";
    $sql .= "'$data_cd',";
    $sql .= "'$data_name',";
    $sql .= "$client_id";
    $sql .= ");";

    $result = Db_Query($db_con,$sql);

    return $result;
}


/**
 * �ѹ����������
 *
 * �ѹ�����
 * 1.0.0 (2007/03/29) ��������(morita-d)
 *
 * @author      morita-d
 *
 * @version     1.0.0 (2007/03/29)
 *
 * @param               resource    $db_con         DB�꥽����
 * @param               string      $mst_name       �ޥ���̾
 * @param               int         $id             �ǡ���ID
 *
 * @return              array       �ѹ�����
 *
 */
function Log_Get($db_con,$mst_name,$id){

    //ô����ID������å�ID����
    $shop_id  = $_SESSION["client_id"];

    $sql ="
        SELECT
        staff_id,
        staff_name,
        --CAST( work_time AS DATE)
        work_time
        FROM t_mst_log
        WHERE shop_id = $shop_id 
        AND data_id = $id
        AND work_div = 2
        AND mst_name = '����ޥ���'
        ORDER BY work_time DESC
        LIMIT 2 OFFSET 0
    ";

    $result = Db_Query($db_con,$sql);
    $data   = pg_fetch_all($result);

    return $data;
}


/**
 * CSV�����Υǡ��������
 *
 * ��������Ǥ��Ȥ˥���ޤ��������롣
 *
 * �ѹ�����
 * 1.0.0 (2005/03/22) ��������(watanabe-k)
 * 1.0.1 (2006/02/01) �Խ��ʤդ�����
 * 1.0.2 (2006/02/18) ���������ڡ�
 * 1.0.3 (2006/10/17) str_replace �� mb_ereg_replace�ʤ�����
 * 1.0.4 (2006/12/07) SJIS��ʸ���������Ѵ���Ǹ�ˤ����ʤ�����
 *
 * @author              watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version             1.0.4 (2006/12/07)
 *
 * @param               array           $row        CSV������쥳���ɤΥꥹ��
 * @param               string          $header     CSV�ե������1���ܤ��ɲä���إå�
 *
 * @return              array
 *
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/07      12-004      kajioka-h   mb_ereg_replace��str_replace���ᤷ��
 *                  12-018      kajioka-h   Ʊ��
 */
function Make_Csv($row ,$header){

/**************���ڽ���*******************************/
    //�쥳���ɤ�̵�����ϡ�CSV�ǡ�����NULL��ɽ��������
    //$row = (count($row) == 0) ? "" : $row;
    if(count($row)==0){
        $row[] = array("","");
    }
/****************************************************/

    // ����˥إå��Ԥ��ɲ�
    $count = array_unshift($row, $header);

        
    //�ִ�����ʸ��
    $trans = array("\n" => "��", "\r" => "��");


    // ����
    for($i = 0; $i < $count; $i++){
        for($j = 0; $j < count($row[$i]); $j++){


            //���ԥ����ɤ����ѥ��ڡ������ִ�
            $row[$i][$j] = strtr($row[$i][$j], $trans);

            // ���󥳡��ǥ���
            //$row[$i][$j] = mb_convert_encoding($row[$i][$j], "SJIS", "EUC-JP");
            // "��""
            $row[$i][$j] = str_replace("\"", "\"\"", $row[$i][$j]);
            //$row[$i][$j] = mb_ereg_replace("\"", "\"\"", $row[$i][$j]);
            // ""�ǰϤ�
            $row[$i][$j] = "\"".$row[$i][$j]."\"";
        }
        // ����򥫥�޶��ڤ�Ƿ��
        $data_csv[$i] = implode(",", $row[$i]);
    }
    $data_csv = implode("\n", $data_csv);
    // ���󥳡��ǥ���
    $data_csv = mb_convert_encoding($data_csv, "SJIS", "EUC-JP");
    return $data_csv;

}

/**
 * DB����ǡ�����������롣
 *
 *
 *
 * �ѹ�����
 * 1.0.0 (2005/03/22) ��������(watanabe-k)
 *
 * @author              watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version             1.0.0 (2005/03/22)
 *
 * @param               string          $result     ���������
 *
 * @return              array
 *
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/05/28      xx-xxx      kajioka-h   $output_type�ˡ�5�פ��ɲ�
 *                                          �ʡ�3������ȤäƼ��������ǡ�����DB���ͤù���Ǥ�͡�����Ĥ��ơ�;�פʥ������դ��Ƥ�衪��
 *
 */
function Get_Data($result, $output_type="", $key_type=""){
    $result_count = pg_numrows($result);

    $key_type = ($key_type == "ASSOC") ? "PGSQL_ASSOC" : "PGSQL_NUM";

    if ($key_type == "PGSQL_NUM"){

        for($i = 0; $i < $result_count; $i++){
            $row[] = @pg_fetch_array ($result, $i,PGSQL_NUM);
        }

/*
        if($output_type != 2 && $output_type != 3){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(htmlspecialchars($row[$i][$j]));
                }
            }
        }

		//�����ˡ֣��פ���ꤷ����addslashes��Ԥ�
		if($output_type == 3){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(addslashes($row[$i][$j]));
                }
            }
        }
*/

        //�����ˡ�1�פ���ꤷ�����ޤ��ϻ��̵꤬������htmlspecialchars��Ԥ�
        if($output_type == null || $output_type == 1){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(htmlspecialchars($row[$i][$j]));
                }
            }
        }

        //�����ˡ�2�פ���ꤷ�����ϲ��⤷�ʤ�
        if($output_type == 2){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = $row[$i][$j];
                }
            }
        }

        //�����ˡ�3�פ���ꤷ����addslashes��Ԥ�
        if($output_type == 3){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(addslashes($row[$i][$j]));
                }       
            }       
        }       

        //�����ˡ�4�פ���ꤷ����addslashes��htmlspecialchars��nl2br��Ԥ�
        if($output_type == 4){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(addslashes(htmlspecialchars($row[$i][$j])));
                }       
            }       
        }

        //�����ˡ�5�פ���ꤷ����addslashes�Τߤ�Ԥ�
        if($output_type == 5){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = addslashes($row[$i][$j]);
                }
            }
        }

    }else{

        for ($i=0; $i<$result_count; $i++){
            $row[] = @pg_fetch_array ($result, $i, PGSQL_ASSOC);
        }

        if ($output_type != 2){
            foreach ($row as $key1 => $value1){
                foreach ($value1 as $key2 => $value2){
                    $row[$key1][$key2] = nl2br(htmlspecialchars($value2));
                }
            }
        }

    }

    return $row;
}

/**
*Get�����ͤ������ʾ��ϥᥤ���˥塼������
*
*
*
*
*�ѹ�����
*1.0.0 (2006/2/10) ��������(watanabe-k)
*
*
*@author                watanabe-k<watanabe-k@bhsk.co.jp>
*
*@version               1.0.0 (2005/03/22)
*
*@param                 string? 
*
*@return                void
*
*/
function Get_Id_Check($result){
    $num = pg_num_rows($result);
    if($num == 0){
        Header("Location: ../top.php"); 
    }
}


/**
*Get�����ͤ�NULL�ξ��ϥᥤ���˥塼������
*
*
*
*
*�ѹ�����
*1.0.0 (2006/2/10) ��������(suzuki-t)
*
*
*@author                suzuki-t
*
*@version               1.0.0 (2006/05/08)
*
*@param                 string? 
*
*@return                void
*
*/
function Get_Id_Check2($num){
    if($num == NULL){
        Header("Location: ../top.php"); 
    }
}
 
/**
*GET�����ͤ�int�ʳ��ξ��ϥᥤ���˥塼������
*
*
*
*
*�ѹ�����
*1.0.0 (2006/10/18) ��������(watanabe-k)
*
*
*@author                watanabe-k
*
*@version               1.0.0
*
*@param                 ????? 
*
*@return                void
*
*/
function Get_Id_Check3($num){
    if($num != NULL){

        //����ξ��
        if(is_array($num)){

            for($i = 0; $i < count($num); $i++){
                if(!ereg("^[0-9]+$", $num[$i])){
                    header("Location: ../top.php");
                    exit;
                }
            }

        //����ʳ��ξ��
        }else{
            if(!ereg("^[0-9]+$", $num)){
                header("Location: ../top.php");
            }
        }
    }
}


/**
* GET����ID��������������å�
*
* �ѹ�����
* 1.0.0 (2006/11/20) ��������
*
* @author       fu
* @version      1.0.0
* @param        
*               int/string      $get_data
*               string          $get_col
*               string          $type
*               string          $where
* @return       boolean         $valid_flg
*
*/
function Get_Id_Check_Db($db_con, $get_data, $get_col, $table, $type, $where=null){

    // GET�ǡ����Υ����פ����ͤξ��
    if ($type == "num"){

        // GET�ǡ����ο��ͥ����å�����̤�ե饰��
        $safe_flg = (ereg("^[0-9]+$", $get_data)) ? true : false;

    // GET�ǡ����Υ����פ�ʸ����ξ��
    }elseif ($type == "str"){

        // �ü�ʸ���򥨥������סܡ�'�פǰϤ�
        $get_data = "'".addslashes($get_data)."'";

        $safe_flg = true;

    }

    // ���顼��̵�����
    if ($safe_flg === true){
        $sql  = "SELECT \n";
        $sql .= "   * \n";
        $sql .= "FROM \n";
        $sql .= "   $table \n";
        $sql .= "WHERE \n";
        $sql .= "   $get_col = $get_data \n";
        $sql .= ($where != null) ? "AND $where \n" : null;
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        $safe_flg = ($num > 0) ? true : false;
    }

    return $safe_flg;

}


/**
 *
 * POST���줿�ǡ�����������Ͽ����Ƥ���ǡ����Ƚ�ʣ���Ƥ��ʤ��������å�
 *
 * �ѹ�����
 * 1.0.0 (2006 ��ʬ)    �դ�����������
 *
 * @author      �դ���
 *
 * @version     1.0.0 (2006 ��ʬ)
 *
 * @param       string      $con            DB��³�ؿ�
 * @param       string      $status         ���ơ������ʿ������ѹ���
 * @param       string      $origin_data    �ѹ����ǡ�����̵������null��
 * @param       string      $post_data      POST���줿�ǡ���
 * @param       string      $sql            ��ʣ������å�����SQL
 *
 * @return      boolean                     ���顼��true
 *
 */
function Duplicate_Chk($con, $status, $origin_data, $post_data, $sql){

    // POST���줿�ǡ���������ξ��ʣ��ե�����ν�ʣ�����å��ξ���
    if (is_array($post_data)){
        $post_data = $post_data[0]."-".$post_data[1];
        // �ѹ��ξ��ʸ��ǡ������������
        if ($status == "chg"){
            $origin_data = $origin_data[0]."-".$origin_data[1];
        }
    }

    // ������Ͽ�ξ�硦�ѹ��Ǹ��ǡ�����POST�ǡ������㤦���
    if ( (($status == "add") && ($post_data != null) ||
         (($status == "chg") && ($origin_data != $post_data) && ($post_data) != null)) ){

        $res = Db_Query($con, $sql);

        // �����쥳���ɤ�1��ʾ夢��н�ʣ���顼
        return (pg_fetch_result($res, 0, 0) >= 1) ? true : false;

    }

    return false;

}


    
/**
 *
 * POST���줿�ǡ�����������Ͽ����Ƥ���ǡ����Ƚ�ʣ���Ƥ��ʤ��������å�
 *
 * �ѹ�����
 * 1.0.0 (2006 ��ʬ)    �դ�����������
 *
 * @author      �դ���  
 *
 * @version     1.0.0 (2006 ��ʬ)
 *
 * @param       double      $coax            ü����ʬ
 * @param       double      $price           ���
 *
 * @return      double                      
 *
 */
function Coax_Col($coax, $price){
    #2010-05-13 hashimoto-y
    if($price >= 0){
        if($coax == '1'){
            $price = floor($price);
        }elseif($coax == '2'){
            $price = round($price);
        }elseif($coax == '3'){
            $price = ceil($price);
        }
    }else{
        if($coax == '1'){
            $price = ceil($price);
        }elseif($coax == '2'){
            $price = round($price);
        }elseif($coax == '3'){
            $price = floor($price);
        }
    }

    return $price;
}

/**
 *
 *��׶�ۡ������ǹ�ס���ɼ��ۤ򻻽Ф���
 *
 * �ѹ�����
 * 1.0.0 (2006 ��ʬ)    �դ�����������
 *
 * @author      �դ���
 *
 * @version     1.0.0 (2006 ��ʬ)
 *
 * @param       array       $price_data     ���줾��ξ��ʤι�׶��
 * @param       array       $tax_div        ���줾��ξ��ʤβ��Ƕ�ʬ
 * @param       string      $coax           �ݤ��ʬ
 * @param       string      $tax_franct     ü����ʬ
 * @param       string      $tax_rate       ������Ψ
 * @param       int         $client_id      ������ID
 * @param       object      $db_con         Db�ȤΥ��ͥ������
 *
 * @return      array                       ��׶�ۡ������ǹ�ס���ɼ���
 *
 */
//function Total_Amount($price_data, $tax_div, $coax="1", $tax_franct="1", $tax_rate="5", $client_id, $db_con){
function Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con){
    //������β��Ƕ�ʬ�����
    $sql  = "SELECT";
    $sql .= "   c_tax_div ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $c_tax_div = pg_fetch_result($result, 0,0);

    //������Ψ
    $rate = bcdiv($tax_rate, 100, 2);

    //������Ψ�ǡ��ܡ���
    $in_rate = bcadd($rate,1,2);

    //��ɼ��פ������
    if(is_array($price_data) === true){

        //���ʿ��롼��
        for($i = 0; $i < count($price_data); $i++){
            $buy_amount = str_replace(',','',$price_data[$i]);

            //���Ƕ�ʬ�����
            if($c_tax_div == '1' && $tax_div[$i] == '1'){
                $tax_div[$i] = '1';             //����
            }elseif($c_tax_div == '2' && $tax_div[$i] == '1'){
                $tax_div[$i] = '2';             //����
            }elseif($tax_div[$i] == '3'){
                $tax_div[$i] = '3';             //�����
            }

            //�������Ȥ�NULL�ξ��ϡ�������Ԥ�ʤ�
            if($buy_amount != null){
                //���Ƕ�ʬ���Ȥ˾��ʤι�פ����
                //���Ǥξ��
                if($tax_div[$i] == '1'){
                    $outside_buy_amount     = bcadd($outside_buy_amount,$buy_amount);
                //���Ǥξ��
                }elseif($tax_div[$i] == '2'){
                    $inside_amount          = bcadd($inside_amount, $buy_amount);

                }elseif($tax_div[$i] == '3'){
                    $exemption_buy_amount   = bcadd($exemption_buy_amount, $buy_amount);
                }
            }
        }

        //�����Ǥ����
        //����
        if($outside_buy_amount != 0){
            $outside_tax_amount   = bcmul($outside_buy_amount, $rate,2);                    //�����ǳۡʴݤ�����
            $outside_tax_amount   = Coax_Col($tax_franct, $outside_tax_amount);             //�����ǳۡʴݤ���
        }

        //����
        if($inside_amount != 0){
            $in_rate              = bcmul($in_rate,100);
            $inside_tax_amount    = bcdiv($inside_amount, $in_rate,2);
            $inside_tax_amount    = bcmul($inside_tax_amount, $tax_rate,2);
            $inside_tax_amount    = Coax_Col($tax_franct, $inside_tax_amount);
            $inside_buy_amount    = bcsub($inside_amount, $inside_tax_amount);
        }
        

        //��ȴ����۹��
        $buy_amount_all     = $outside_buy_amount + $inside_buy_amount + $exemption_buy_amount;
        //�����ǹ��
        $tax_amount_all     = $outside_tax_amount + $inside_tax_amount;
        //�ǹ��߶�۹��
        $total_amount       = $buy_amount_all + $tax_amount_all;

/*
                //�����Ǥ򻻽�
                //����  
                if($tax_div[$i] == '1'){
                    $tax_amount = bcmul($buy_amount,$rate,2);
                    $tax_amount = Coax_Col($tax_franct,$tax_amount);
                //����
                }elseif($tax_div[$i] == '2'){
                    $tax_amount = bcdiv($buy_amount, $in_rate,2);
                    $tax_amount = bcsub($buy_amount, $tax_amount,2);
                    $tax_amount = Coax_Col($tax_franct,$tax_amount);
                    $buy_amount = bcsub($buy_amount, $tax_amount);

                //�����
                }elseif($tax_div[$i] == '3'){
                    $tax_amount = 0;
                }

                //�����ǹ��
                $tax_amount_all = bcadd($tax_amount_all, $tax_amount);

                //������۹�ס���ȴ��
                $buy_amount_all = bcadd($buy_amount_all, $buy_amount);
        
                //������۹�ס��ǹ���
                $total_amount = bcadd($buy_amount_all, $tax_amount_all);
                $total_amount_all = bcadd($total_amount_all, $total_amount);
            }
        }
*/
    //��ñ�̤ι�פ������
    }else{
        if($tax_div == null){
            $tax_div == '1';
        }

        //���Ƕ�ʬ�����
        if($c_tax_div == '1' && $tax_div == '1'){
            $tax_div = '1';             //����
        }elseif($c_tax_div == '2' && $tax_div == '1'){
            $tax_div = '2';             //����
        }elseif($tax_div == '3'){
            $tax_div = '3';             //�����
        }

        //���
        $buy_amount = str_replace(',','',$price_data);

        //������
        //����
        if($tax_div[$i] == '1'){
            $tax_amount = bcmul($buy_amount,$rate,2);
            $tax_amount = Coax_Col($tax_franct, $tax_amount);
        //����
        //��˾����ǳۤ��ᡢ��׶�ۤ�������ǳۤ��������Τ���ȴ����ۤȤ��롣
        }elseif($tax_div[$i] == '2'){
            $tax_amount = bcdiv($buy_amount, $in_rate,2);
            $tax_amount = bcsub($buy_amount, $tax_amount,2);
            $tax_amount = Coax_Col($tax_franct, $tax_amount);
            $buy_amount = bcsub($buy_amount, $tax_amount);
        //�����
        }elseif($tax_div[$i] == '3'){
            $tax_amount = 0;
        }

        $buy_amount_all = $buy_amount;
        $tax_amount_all = $tax_amount;

        $total_amount = bcadd($buy_amount, $tax_amount);
    }

    $data = array($buy_amount_all, $tax_amount_all, $total_amount);
    return $data;
}
       
    
/**
 *
 * Get���ϤäƤ����ǡ����μ������Υ����ɤ����
 *
 * �ѹ�����
 * 1.0.0 (2006 ��ʬ)    �դ�����������
 *
 * @author      �դ���  
 *
 * @version     1.0.0 (2006 ��ʬ)
 *
 * @param       string      $con            DB��³�ؿ�
 * @param       string      $table          �ơ��֥�̾
 * @param       string      $get_cd         �ϤäƤ���ID�����Ф���������(�����ɤ����Ĥ������,�Ƕ��ڤ�)
 * @param       strint      $type           ������FC��������ʬ
 * 
 * 
 *
 * @return      array                       �������Υ�����
 *
 */
function Make_Get_Id($conn, $table, $get_cd, $type=null){
//$table �б�ɽ
//goods     : ���ʥޥ���
//client    ��������ޥ������������
//staff     �������åեޥ���
//supplier  ��������ޥ����ʻ������
//direct    ��ľ����ޥ���
//compose   �������ʥޥ���
//make_goods����¤�ʥޥ���
    //���ʥޥ���
    if($table == "goods"){
		//����Ƚ��
        if($type == '2'){
	        $sql  = "SELECT";
	        $sql .= "   t_goods.goods_cd";
	        $sql .= " FROM";
	        $sql .= "   t_goods_info";
	        $sql .= "       INNER JOIN";
	        $sql .= "   t_goods";
	        $sql .= "       ON t_goods_info.goods_id = t_goods.goods_id";
	        $sql .= " WHERE";
			//ľ��Ƚ��
			if($_SESSION[group_kind] == '2'){
				//ľ��
				$sql .= "   t_goods_info.shop_id IN(".Rank_Sql().")";
	            $sql .= "   AND ";
                //ľ�Ĥ��������ʤ�ͭ���ޤ���ͭ����ľ�ġˤξ��ʤȡ�FC���ʡ�ͭ����̵���ط��ʤ����ơ�
                $sql .= "   ( ";
                $sql .= "      (t_goods.public_flg = true AND t_goods.state IN (1, 3)) ";
                $sql .= "      OR t_goods.public_flg = false ";
                $sql .= "   ) ";
	        }else{ 
				//�ƣ�
				$sql .= "   t_goods_info.shop_id = ".$_SESSION[client_id]."";
	            $sql .= "   AND ";
                //FC���������ʤ�ͭ���ξ��ʤȡ�FC���ʡ�ͭ����̵���ط��ʤ����ơ�
                $sql .= "   ( ";
                $sql .= "      (t_goods.public_flg = true AND t_goods.state = 1) ";
                $sql .= "      OR t_goods.public_flg = false ";
                $sql .= "   ) ";
			}
	        $sql .= "   AND";
	        $sql .= "   t_goods_info.head_fc_flg = 'f'";
	        $sql .= "   AND";
	        $sql .= "   t_goods.accept_flg = '1'";
	        $sql .= " ORDER BY t_goods.goods_cd;";
        }else{  
			//����
            $sql  = "SELECT";
            $sql .= "   goods_cd";
            $sql .= " FROM";
            $sql .= "   t_goods";
            $sql .= " WHERE";
            $sql .= "   public_flg = 't'";
            $sql .= " ORDER BY goods_cd";
            $sql .= ";";
        }

    //ľ����ޥ���
    }elseif($table == "direct" ){
	    $sql  = "SELECT";
	    $sql .= "   direct_cd";
	    $sql .= " FROM";
	    $sql .= "   t_direct";
	    $sql .= " WHERE";
	    //ľ��Ƚ��
		if($_SESSION[group_kind] == '2'){
			//ľ��
			$sql .= "   shop_id IN(".Rank_Sql().")";
	    }else{ 
			//�������ƣ�
			$sql .= "   shop_id = ".$_SESSION[client_id]."";
		}
	    $sql .= " ORDER BY direct_cd";
	    $sql .= ";";
    //������
    }elseif($table == "supplier"){
	    $sql  = "SELECT";
	    $sql .= "   client_cd1";
	    $sql .= " FROM";
	    $sql .= "   t_client";
	    $sql .= " WHERE";
	    $sql .= "   client_div = '2'";
	    $sql .= "   AND";
	    //ľ��Ƚ��
		if($_SESSION[group_kind] == '2'){
			//ľ��
			$sql .= "   shop_id IN(".Rank_Sql().")";
	    }else{ 
			//�������ƣ�
			$sql .= "   shop_id = ".$_SESSION[client_id]."";
		}
	    $sql .= "   ORDER BY client_cd1";
	    $sql .= ";";
    //������
    }elseif($table == "client"){
		//����Ƚ��
//        if($type == '2'){
	        $sql  = "SELECT";
	        $sql .= "   client_cd1 ||','|| client_cd2";
	        $sql .= " FROM";
	        $sql .= "   t_client";
	        $sql .= " WHERE";
	        //ľ��Ƚ��
			if($_SESSION[group_kind] == '2'){
				//ľ��
				$sql .= "   shop_id IN(".Rank_Sql().")";
		    }else{ 
				//�ƣ�
				$sql .= "   shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= "   AND";
	        $sql .= "   client_div = '1'";
	        $sql .= " ORDER BY client_cd1, client_cd2";
	        $sql .= ";";
//        }else{
/*
			//����
            $sql  = "SELECT";
            $sql .= "   client_cd1 ||','|| client_cd2";
            $sql .= " FROM";
            $sql .= "   t_client";
            $sql .= " WHERE";
            $sql .= "   shop_id = ".$_SESSION[client_id];
            $sql .= "   AND";
            $sql .= "   (client_div = '1'";
            $sql .= "   OR";
            $sql .= "   client_div = '3')";
            $sql .= "   ORDER BY client_cd1, client_cd2";
            $sql .= ";";
        }
*/
    //�����åեޥ���
    }elseif($table == "staff"){
		//����Ƚ��
        if($type == '2'){
	        $sql  = "SELECT DISTINCT ";
	        $sql .= "    t_staff.charge_cd ";
	        $sql .= "FROM";
	        $sql .= "    t_attach ";
	        $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
	        $sql .= "WHERE";
			//ľ��Ƚ��
			if($_SESSION[group_kind] == '2'){
				//ľ��
				$sql .= "   t_attach.shop_id IN(".Rank_Sql().")";
		    }else{ 
				//�ƣ�
				$sql .= "   t_attach.shop_id = ".$_SESSION[client_id];
			}
	        $sql .= "ORDER BY t_staff.charge_cd;";
        }else{
			//����
/*
            $sql  = "SELECT DISTINCT ";
            $sql .= "   t_staff.charge_cd ";
            $sql .= " FROM";
            $sql .= "   t_staff";
            $sql .= "   ORDER BY charge_cd";
            $sql .= ";";
*/
            //FC�����ɡ�ô���ԥ����ɤǥ�����
            $sql  = "SELECT \n";
            $sql .= "    t_staff.staff_id \n";
            $sql .= "FROM \n";
            $sql .= "    t_staff \n";
            $sql .= "    INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id \n";
            $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id \n";
            $sql .= "WHERE \n";
            $sql .= "    t_attach.h_staff_flg = false \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_client.client_cd1, \n";
            $sql .= "    t_client.client_cd2, \n";
            $sql .= "    t_staff.charge_cd \n";
            $sql .= ";\n";
        }
	//������
    }elseif($table == "compose"){
	    $sql  = "SELECT";
	    $sql .= "   t_goods.goods_cd";
	    $sql .= " FROM";
	    $sql .= "   t_goods";
	    $sql .= " WHERE";
	    $sql .= "   t_goods.compose_flg = 't'";
	    $sql .= "   ORDER BY t_goods.goods_cd";
	    $sql .= ";";
	    $table = "goods";
	//��¤��
    }elseif($table == "make_goods"){
	    $sql .= "SELECT";
	    $sql .= "   DISTINCT";
	    $sql .= "   t_goods.goods_cd";
	    $sql .= " FROM";
	    $sql .= "   t_goods,";
	    $sql .= "   t_make_goods";
	    $sql .= " WHERE";
	    $sql .= "   t_make_goods.goods_id = t_goods.goods_id";
	    $sql .= "   ORDER BY t_goods.goods_cd";
	    $sql .= ";";
	    $table = "goods";
	//�ƣ�      
    }elseif($table == "shop"){
	    $sql .= "SELECT";
	    $sql .= "   client_cd1 || ',' || client_cd2";
	    $sql .= " FROM";
	    $sql .= "   t_client";
	    $sql .= " WHERE";
	    $sql .= "   client_div = '3'";
	    $sql .= " ORDER BY client_cd1, client_cd2";
	    $sql .= ";";
    }

    $result = Db_Query($conn, $sql);
    $data_num = pg_num_rows($result);
    for($i = 0; $i < $data_num; $i++){
        $cd_data[] = pg_fetch_result($result, $i, 0);
    }
    $current_cd = @array_search($get_cd, $cd_data);

    //����
    $get_cd_data[0] = $cd_data[$current_cd+1];

    //����
    $get_cd_data[1] = $cd_data[$current_cd-1];

    for($i = 0; $i < 2; $i++){
        //����
        if($table == "goods"){
			$sql  = "SELECT";
	        $sql .= "   ".$table."_id";
	        $sql .= " FROM";
	        $sql .= "   t_".$table."";
	        $sql .= " WHERE";
	        $sql .= "   ".$table."_cd = '$get_cd_data[$i]'";
	        $sql .= "   AND";
			//ľ��Ƚ��
			if($_SESSION[group_kind] == '2'){
				//ľ��
				$sql .= "   (shop_id IN(".Rank_Sql().")";
	        }else{ 
				//�������ƣ�
				$sql .= "   (shop_id = ".$_SESSION[client_id];
			}
	        $sql .= "   OR";
	        $sql .= "   public_flg = 't')";
	        $sql .= ";";
        }elseif($table == "direct"){
	        $sql  = "SELECT";
	        $sql .= "   direct_id";
	        $sql .= " FROM";
	        $sql .= "   t_direct";
	        $sql .= " WHERE";
	        $sql .= "   direct_cd = '$get_cd_data[$i]'";
	        $sql .= "   AND";
			//ľ��Ƚ��
			if($_SESSION[group_kind] == '2'){
				//ľ��
				$sql .= "   shop_id IN(".Rank_Sql().")";
	        }else{ 
				//�������ƣ�
				$sql .= "   shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= ";";
        }elseif($table == "supplier"){
			$sql  = "SELECT";
	        $sql .= "   client_id";
	        $sql .= " FROM";
	        $sql .= "   t_client";
	        $sql .= " WHERE";
	        $sql .= "   client_cd1 = '$get_cd_data[$i]'";
	        $sql .= "   AND";
	        //ľ��Ƚ��
			if($_SESSION[group_kind] == '2'){
				//ľ��
				$sql .= "   shop_id IN(".Rank_Sql().")";
	        }else{ 
				//�������ƣ�
				$sql .= "   shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= "   AND";
	        $sql .= "   client_div = '2'";
	        $sql .= ";";
        }elseif($table == "staff"){
	        $sql  = "SELECT";
	        $sql .= "   t_staff.".$table."_id";
	        $sql .= " FROM";
			$sql .= "    t_attach ";
	        $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
	        $sql .= " WHERE";
            if($_SESSION["group_kind"] != "1"){
    	        if($get_cd_data[$i] != NULL){
	                $sql .= "   t_staff.charge_cd = '".$get_cd_data[$i]."' ";
	            }else{
	                $sql .= "   t_staff.charge_cd = null ";
    	        }
            }
			//ľ��Ƚ��
			if($_SESSION[group_kind] == '2'){
				//ľ��
				$sql .= " AND t_attach.shop_id IN(".Rank_Sql().")";
	        }elseif ($_SESSION["group_kind"] == "1"){
                // ����
                //$sql .= null;
                if($get_cd_data[$i] != null){
                    $sql .= " t_staff.staff_id = ".$get_cd_data[$i]."";
                }else{
                    $sql .= " t_staff.staff_id = null ";
                }
            }else{
				// �ƣ�
				$sql .= " AND t_attach.shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= ";";
        }elseif($table == "client"){
            $get_cd_data_exp[$i] = explode(",",$get_cd_data[$i]);

	        $sql  = "SELECT";
	        $sql .= "   ".$table."_id";
	        $sql .= " FROM";
	        $sql .= "   t_".$table."";
	        $sql .= " WHERE";
	        $sql .= "   ".$table."_cd1 = '".$get_cd_data_exp[$i][0]."'";
	        $sql .= "   AND";
	        $sql .= "   ".$table."_cd2 = '".$get_cd_data_exp[$i][1]."'";
	        $sql .= "   AND";
	        //ľ��Ƚ��
			if($_SESSION[group_kind] == '2'){
				//ľ��
				$sql .= "   shop_id IN(".Rank_Sql().")";
	        }else{ 
				//�������ƣ�
				$sql .= "   shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= "   AND";
	        $sql .= "   (client_div = '1'";
	        $sql .= "   OR";
	        $sql .= "   client_div = '3')";
	        $sql .= ";";
        }elseif($table == "shop"){
            $get_cd_data_exp[$i] = explode(",",$get_cd_data[$i]);

	        $sql  = "SELECT";
	        $sql .= "   client_id";
	        $sql .= " FROM";
	        $sql .= "   t_client";
	        $sql .= " WHERE";
	        $sql .= "   t_client.client_cd1 = '".$get_cd_data_exp[$i][0]."'";
	        $sql .= "   AND";
	        $sql .= "   t_client.client_cd2 = '".$get_cd_data_exp[$i][1]."'";
	        $sql .= "   AND";
	        $sql .= "   t_client.client_div = '3'";
	        $sql .= "   AND";
			$sql .= "   t_client.shop_id = ".$_SESSION[client_id]."";
	        $sql .= ";";
        }

        $result = Db_Query($conn, $sql);
        $num = pg_num_rows($result);
        if($num != 0){
            $id_data[$i] = pg_fetch_result($result,0,0);
        }
    }
    return $id_data;
}

/**
 *
 * Get���ϤäƤ�������ǡ����μ������Υ����ɤ����
 *
 * �ѹ�����
 * 1.0.0 (2006 ��ʬ)    suzuki��������
 *
 * @author      suzuki
 *
 * @version     1.0.0 (2006 ��ʬ)
 *
 * @param       string      $con            DB��³�ؿ�
 * @param       string      $client_id      ������ID
 * @param       string      $get_id         �ϤäƤ���ID
 * 
 * 
 *
 * @return      array                       �������Υ�����
 *
 */
function Make_Get_Id2($conn,$client_id,$get_id){
    //����ޥ���
    $sql  = "SELECT";
    $sql .= "   contract_id";
    $sql .= " FROM";
    $sql .= "   t_contract";
    $sql .= " WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= " ORDER BY contract_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $data_num = pg_num_rows($result);
    for($i = 0; $i < $data_num; $i++){
        $cd_data[] = pg_fetch_result($result, $i, 0);
    }

    $current_cd = array_search($get_id, $cd_data);

    //����
    $get_cd_data[0] = $cd_data[$current_cd+1];

    //����
    $get_cd_data[1] = $cd_data[$current_cd-1];

    for($i = 0; $i < 2; $i++){
        if($get_cd_data[$i] != NULL){
            $sql  = "SELECT";
            $sql .= "   contract_id";
            $sql .= " FROM";
            $sql .= "   t_contract";
            $sql .= " WHERE";
            $sql .= "   contract_id = ".$get_cd_data[$i];
            $sql .= "   AND";
            $sql .= "   client_id = $client_id";
            $sql .= ";";
         
            $result = Db_Query($conn, $sql);
            $num = pg_num_rows($result);
            if($num != 0){
                $id_data[$i] = pg_fetch_result($result,0,0);
            }
        }
    }
    return $id_data;
}


/**
 *
 * PHP6�����������ݡ��Ȥ����Ķ��ؿ��ʲ���
 *
 * �ѹ�����
 * 1.0.0 (2006.06.08)    �������٤ʤ����������
 *
 * @author      ��������
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       array     $ary          //ɽ������������
 * @param       string    $str          //�����ȥ�
 * @param       string    $print_type   //�ü�ʸ�������˥���������Ƥ�����Ϥ��Τޤ޽��Ϥ���Ȥ����ʤ��Ȥ�
 *
 * @return      void
 *
 */
function Print_Array($ary, $str=null, $print_type=null){

    $p_type = ($print_type == "xmp") ? "xmp" : "pre";
    $p_type = "xmp";

    print "<pre style=\"font: 10px; font-family: '�ͣ� �����å�'; \">";
    print "<hr>";
    print ($str != null) ? "<b>$str</b><br>" : null;
    print ($p_type == "xmp") ? "<xmp>" : null;
    print_r($ary);
    print ($p_type == "xmp") ? "</xmp>" : null;
    print "</pre>";
}


/**
 *
 * PHP7�����������ݡ��Ȥ����Ķ��ؿ��ʲ���
 *
 * �ѹ�����
 * 1.0.0 (2006.06.08)    �������٤ʤ����������
 *
 * @author      ���٤�����
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       array     $ary      //ɽ������������
 * 
 * 
 *
 * @return      void
 *
 */
function Print_var($ary, $str=null){

    print "<pre style=\"font: 10px; font-family: '�ͣ� �����å�'; \">";
    print "<hr>";
    print ($str != null) ? "<b>$str</b><br>" : null;
    var_dump($ary);
    print "</pre>";
}


/**
 *
 *
 *ľ�Ĥξ���SQL
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
**/
function Rank_Sql($rank=""){
    if ($rank == ""){
        $rank_cd = $_SESSION["rank_cd"];
    }else{
        $rank_cd = $rank;
    }
    $sql = " SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_cd' ";

    return $sql;
}

function Rank_Sql2($rank = ""){

    if ($_SESSION["groyup_kind"] == "2"){
        if ($rank == ""){
            $rank_cd = $_SESSION["rank_cd"];
        }else{
            $rank_cd = $rank;
        }
        $sql = " (SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_cd') ";
    }else{
        $sql = " (".$_SESSION["client_id"].") \n";
    }

    return $sql;
}


/** 
 *���������ƥ���׻�����
 * 
 *
 * �ѹ�����
 * 1.0.0 (2006.07.29)    watanabe-k����������
 *
 * @author      watanabe-k      
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       array     $buy_amount      //ɽ������������
 *              array     $royalty      
 *              int       $royalty_rate
 *              string    $coax
 *
 * @return      void    
 * 
 * 
**/ 
function Total_Royalty($buy_amount, $royalty, $royalty_rate, $coax){
    $rate = bcdiv($royalty_rate, 100,2);
    for($i = 0; $i < count($royalty); $i++){
        $buy_amount[$i] = str_replace(",","",$buy_amount[$i]);
        if($royalty[$i] == '1'){
            $royalty_price = bcmul($buy_amount[$i], $rate,2);
        }

        $royalty_price = Coax_Col($coax, $royalty_price);

        $royalty_total = bcadd($royalty_price, $royalty_total);
    }

    return $royalty_total;
}

/**
 * �ʥ�С��ե����ޥå�
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
**/
function My_Number_Format($num=null, $int=0){
    //
    if($num != null){
        $num = number_format($num, $int);
    }

    //�����

    return $num;
}


/** 
 *����ԡ���Ź�����¤�hierselect�����������ؿ�
 * 
 *
 * �ѹ�����
 * 1.0.0 (2006.07.29)    watanabe-k����������
 *
 * @author      watanabe-k      
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       string    $db_con           DB��³
 *              
 *
 * @return      array
 * 
 * 
**/ 
function Make_Ary_Bank($db_con, $type=null){

    // ��ԡ���Ź�����¾������SQL
    $sql  = "SELECT ";
    $sql .= "   t_bank.bank_id, ";
    $sql .= "   t_bank.bank_cd, ";
    $sql .= "   t_bank.bank_name, ";
    $sql .= "   t_b_bank.b_bank_id, ";
    $sql .= "   t_b_bank.b_bank_cd, ";
    $sql .= "   t_b_bank.b_bank_name, ";
    $sql .= "   t_account.account_id, ";
    $sql .= "   CASE t_account.deposit_kind ";
    $sql .= "       WHEN '1' THEN '����' ";
    $sql .= "       WHEN '2' THEN '����' ";
    $sql .= "   END ";
    $sql .= "   AS deposit, ";
    $sql .= "   t_account.account_no ";
    $sql .= "FROM ";
    $sql .= "   t_bank ";
    $sql .= "   INNER JOIN t_b_bank ON t_bank.bank_id = t_b_bank.bank_id ";
    $sql .= "   INNER JOIN t_account ON t_b_bank.b_bank_id = t_account.b_bank_id ";
    $sql .= "WHERE ";
    $sql .= ($_SESSION["group_kind"] == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = ".$_SESSION["client_id"]." ";
    #2010-04-21 hashimoto-y
    $sql .= "AND t_bank.nondisp_flg = false ";
    $sql .= "AND t_b_bank.nondisp_flg = false ";
    $sql .= "AND t_account.nondisp_flg = false ";
    $sql .= "ORDER BY ";
    $sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd, t_account.account_no ";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // hierselect���������
    $ary_hier1[null] = null; 
    $ary_hier2       = null; 
    $ary_hier3       = null;

    // 1��ʾ夢����
    if ($num > 0){

        for ($i=0; $i<$num; $i++){

            // �ǡ��������ʥ쥳�������
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);

            // ʬ����䤹���褦�˳Ƴ��ؤ�ID���ѿ�������
            $hier1_id = $data_list[$i]["bank_id"];
            $hier2_id = $data_list[$i]["b_bank_id"];
            $hier3_id = $data_list[$i]["account_id"];

            /* ��1��������������� */
            // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
                // ��1���ؼ��������ƥ�������
//                $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]." �� ".htmlspecialchars($data_list[$i]["bank_name"]);
                $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]." �� ".htmlentities($data_list[$i]["bank_name"], ENT_COMPAT, EUC);
            }

            /* ��2��������������� */
            // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
            // �ޤ��ϡ����߻��ȥ쥳���ɤλ�Ź�����ɤ����˻��Ȥ����쥳���ɤλ�Ź�����ɤ��ۤʤ���
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
                $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
                // ��2���إ��쥯�ȥ����ƥ�κǽ��NULL������
                if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
                    //$ary_hier2[$hier1_id][null] = "";
                    $ary_hier2[$hier1_id][0] = ""; //2015-03-24 amano
                }
                // ��2���ؼ��������ƥ�������
//                $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]." �� ".htmlspecialchars($data_list[$i]["b_bank_name"]);
                $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]." �� ".htmlentities($data_list[$i]["b_bank_name"], ENT_COMPAT, EUC);
            }

            /* ��3��������������� */
            // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
            // �ޤ��ϡ����߻��ȥ쥳���ɤλ�Ź�����ɤ����˻��Ȥ����쥳���ɤλ�Ź�����ɤ��ۤʤ���
            // �ޤ��ϡ����߻��ȥ쥳���ɤθ����ֹ�����˻��Ȥ����쥳���ɤθ����ֹ椬�ۤʤ���
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
                $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"] ||
                $data_list[$i]["account_no"] != $data_list[$i-1]["account_no"]){
                // ��3���إ��쥯�ȥ����ƥ�κǽ��NULL������
                if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] || 
                    $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
                    $ary_hier3[$hier1_id][$hier2_id][null] = "";
                }
                // ��3���ؼ��������ƥ�������
                $ary_hier3[$hier1_id][$hier2_id][$hier3_id] = $data_list[$i]["deposit"]." �� ".$data_list[$i]["account_no"];
            }

        }
        // 1�Ĥ�����ˤޤȤ��֤�
        return array($ary_hier1, $ary_hier2, $ary_hier3);

    // 1���̵�����
    }else{

        // ����������֤�
//        return array(array(""), array(""), array(""));
        //array(null)�ˤ���ȡ�array[0]=null�Ȥʤ�Τ�[null][]
        $array[null] = "";
        return array($array, $array, $array);
    }

}

/** 
 *����Ź�������hierselect�����������ؿ�
 * 
 *
 * �ѹ�����
 * 1.0.0 (2006.07.29)    watanabe-k����������
 *
 * @author      watanabe-k      
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       string    $db_con           DB��³
 *              
 *
 * @return      array
 * 
 * 
**/ 
function Make_Ary_Branch($db_con, $shop_id=null){

    $sql  = "SELECT ";
    $sql .= "   t_branch.branch_id, ";
    $sql .= "   t_branch.branch_cd, ";
    $sql .= "   t_branch.branch_name, ";
    $sql .= "   t_part.part_id, ";
    $sql .= "   t_part.part_cd, ";
    $sql .= "   t_part.part_name ";
    $sql .= "FROM ";
    $sql .= "   t_branch ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_part ";
    $sql .= "   ON t_branch.branch_id = t_part.branch_id ";
    $sql .= "WHERE ";
    //����å׻��ꤵ��Ƥ��ʤ����
    if($shop_id != null){
        $sql .= "   t_branch.shop_id = ".$shop_id." ";
    }else{
        $sql .= "   t_branch.shop_id = ".$_SESSION["client_id"]." ";
    }
    $sql .= "ORDER BY t_branch.branch_cd, t_part.part_cd ";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // hierselect���������
    $ary_hier1[null] = null;
    $ary_hier2       = null;

    // 1��ʾ夢����
    if ($num > 0){

        for ($i=0; $i<$num; $i++){

            // �ǡ��������ʥ쥳�������
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);

            // ʬ����䤹���褦�˳Ƴ��ؤ�ID���ѿ�������
            $hier1_id = $data_list[$i]["branch_id"];
            $hier2_id = $data_list[$i]["part_id"];

            /* ��1��������������� */
            // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
            if ($data_list[$i]["branch_cd"] != $data_list[$i-1]["banch_cd"]){
                // ��1���ؼ��������ƥ�������
//                $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]." �� ".htmlspecialchars($data_list[$i]["bank_name"]);
                $ary_hier1[$hier1_id] = $data_list[$i]["branch_cd"]." �� ".htmlentities($data_list[$i]["branch_name"], ENT_COMPAT, EUC);
            }

            /* ��2��������������� */
            // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
            // �ޤ��ϡ����߻��ȥ쥳���ɤλ�Ź�����ɤ����˻��Ȥ����쥳���ɤλ�Ź�����ɤ��ۤʤ���
            if ($data_list[$i]["branch_cd"] != $data_list[$i-1]["branch_cd"] ||
                $data_list[$i]["part_cd"] != $data_list[$i-1]["part_cd"]){
                // ��2���إ��쥯�ȥ����ƥ�κǽ��NULL������
                if ($data_list[$i]["branch_cd"] != $data_list[$i-1]["branch_cd"]){
                    $ary_hier2[$hier1_id][null] = "";
                }
                // ��2���ؼ��������ƥ�������
//                $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]." �� ".htmlspecialchars($data_list[$i]["b_bank_name"]);
                $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["part_cd"]." �� ".htmlentities($data_list[$i]["part_name"], ENT_COMPAT, EUC);
            }

        }

        // 1�Ĥ�����ˤޤȤ��֤�
        return array($ary_hier1, $ary_hier2);

    // 1���̵�����
    }else{

        // ����������֤�
//        return array(array(""), array(""), array(""));
        //array(null)�ˤ���ȡ�array[0]=null�Ȥʤ�Τ�[null][]
        $array[null] = "";
        return array($array, $array);
    }

}


/** 
* ���� ɽ���ڡ�����������������å����������ʥڡ������֤� 
* 
* ����  
* 
* @param string    $all_num  �ǡ��������� 
* @param string    $limit    1�ڡ�����ɽ����� 
* @param string    $page     ���ߤΥڡ�����
* 
* @return array          ɽ���ڡ������ڡ����γ��Ϸ�����ڡ����ν�λ���
* 
*/
function Check_Page ($all_num, $limit, $page="1") {

    //ɽ�������0�ξ��ϣ��ڡ����ܤ�ɽ��
    if ($all_num == "0" ) { 
        $data[0] = 1;
        $data[1] = 0;
        $data[2] = 0;
    
        return $data;
    }

    //�ڡ������η׻�(�ǽ��ڡ����κǸ�ޤǥǡ�����������)
    if (($all_num % $limit) == "0" ) {
        $all_page = ($all_num / $limit);

    //�ڡ������η׻��ʺǽ��ڡ���������ޤǤ����ǡ�����̵������
    } else {
        $all_page = (int)($all_num / $limit)+1;
    }

    //1�ڡ����ʲ��ξ�硢1�ڡ����ܤ�ɽ������
    if ($page < 1) {
        $page = 1;
    //�ǽ��ڡ����ʹߤξ�硢�ǽ��ڡ�����ɽ������
    } elseif ($all_page < $page) {
        $page = $all_page;
    }

    //ɽ�����Ϸ����׻�
    $page_snum = (($page -1) * $limit) +1; 
    
    //ɽ����λ�����׻�
    $page_enum   = $page * $limit; 
    //��������ɽ����λ�����¿�����ϡ�������ޤ�ɽ������
    if ($all_num < $page_enum) {
        $page_enum = $all_num;
    }

    $data[0] = $page;
    $data[1] = $page_snum;
    $data[2] = $page_enum;

    return $data;
}

/**
 *
 * ���դ���������줿���֤��ɤ���������å�
 *
 * @param       resource    $db_con     DB��³�꥽����
 * @param       int         $client_id  �����ID
 * @param       string      $client_div ������ʬ
 *                              0����ʬ��ê���ѡ�
 *                              1��������Ȥ��ƻȤ��Ƥ���
 *                              2��������Ȥ��ƻȤ��Ƥ���
 * @param       string      $y          �����å��������դ�ǯ
 *                          $m          �����å��������դη�
 *                          $d          �����å��������դ���
 *
 * @return      bool        true        ���������Ƥʤ�
 *                          false       ���������Ƥ���
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.1 (2006/10/17)
 *
 */
function Check_Monthly_Renew($db_con, $client_id, $client_div, $y, $m, $d, $shop_id="")
{
    $shop_id = ($shop_id == "") ? $_SESSION["client_id"] : $shop_id;

    $max_day = START_DAY;
    $today  = str_pad($y, 4, "0", STR_PAD_LEFT)."-";
    $today .= str_pad($m, 2, "0", STR_PAD_LEFT)."-";
    $today .= str_pad($d, 2, "0", STR_PAD_LEFT);

    //����η�����������
    $sql  = "SELECT \n";
    $sql .= "    COALESCE(MAX(close_day), '".START_DAY."') \n";
    $sql .= "FROM \n";
    $sql .= "    t_sys_renew \n";
    $sql .= "WHERE \n";
    $sql .= "    shop_id = ".$shop_id." \n";
    $sql .= "    AND \n";
    $sql .= "    renew_div = '2' \n";
    $sql .= ";\n";
//print_array($sql);

    $result = Db_Query($db_con, $sql);
    $close_day = (pg_num_rows($result) == 0) ? $max_day : pg_fetch_result($result, 0, 0);

    if($client_div == "0"){
        if($close_day < $today){
            return true;
        }else{
            return false;
        }
    }

    //�ǽ��η��ݡ���ݡ˻Ĺ���Ͽ�������
    //�ʤޤ�������򤷤Ƥ��ʤ�or�ɲä��줿������ʻ�����ˡ�
    $sql  = "SELECT \n";
    $sql .= "    COALESCE(MAX(monthly_close_day_this), '".START_DAY."') \n";
    $sql .= "FROM \n";
    if($client_div == "1"){
        $sql .= "    t_ar_balance \n";
    }else{
        $sql .= "    t_ap_balance \n";
    }
    $sql .= "WHERE \n";
    $sql .= "    client_id = ".$client_id." \n";
    $sql .= "    AND \n";
    $sql .= "    shop_id = ".$shop_id." \n";
    $sql .= ";\n";
//print_array($sql);

    $result = Db_Query($db_con, $sql);
    $monthly_close_day = (pg_num_rows($result) == 0) ? $max_day : pg_fetch_result($result, 0, 0);

    if($close_day < $today && $monthly_close_day < $today){
        return true;
    }

    return false;

}

/**
 *
 * ���դ������������ʹߤ��ɤ���������å�
 *
 * @param       resource    $db_con     DB��³�꥽����
 * @param       int         $client_id  ������ID 
 * @param       string      $y          �����å��������դ�ǯ
 *                          $m          �����å��������դη�
 *                          $d          �����å��������դ���
 *
 * @return      bool        true        �������������
 *                          false       ��������������
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 * @version     1.0.0 (2006/09/20)
 *
 */
function Check_Bill_Close_Day($db_con, $client_id, $y, $m, $d){
/*
    $sql  = "SELECT\n";
    $sql .= "   COALESCE(MAX(close_day), '".START_DAY."') \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill\n";
    $sql .= "WHERE\n";
    //���������ξ��
    if($_SESSION[shop_id] == 1){
        $sql .= "   t_bill.claim_id = (SELECT\n";
        $sql .= "                           claim_id\n";
        $sql .= "                       FROM\n";
        $sql .= "                           t_claim\n";
        $sql .= "                       WHERE\n";
        $sql .= "                           client_id = $client_id\n";
        $sql .= "                       )\n";
    //FC�����ξ��
    }else{
        $sql .= "   t_bill.claim_id = $client_id\n";
    }

    $sql .= ";\n";
*/
    $sql  = "SELECT\n";
    $sql .= "   COALESCE(MAX(bill_close_day_this), '".START_DAY."') \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill_d \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill_d.client_id = $client_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $bill_close_day = pg_fetch_result($result, 0,0);

    //�������Ϥ��줿���դ���
    $y = str_pad($y, 4, 0, STR_PAD_LEFT);
    $m = str_pad($m, 2, 0, STR_PAD_LEFT);
    $d = str_pad($d, 2, 0, STR_PAD_LEFT);
    $pram_date = $y."-".$m."-".$d;

    //��Ф������դ��Ϥ��줿���դ���礭�����ϥ��顼
    if($bill_close_day >= $pram_date){
        return false;
    }
    return true;
}

/**
 *
 * ���դ������������ʹߤ��ɤ���������å�
 *
 * @param       resource    $db_con     DB��³�꥽����
 * @param       int         $client_id  ������ID
 * @param       string      $y          �����å��������դ�ǯ
 *                          $m          �����å��������դη�
 *                          $d          �����å��������դ���
 * @param       int         $shop_id    ����å�ID
 *
 * @return      bool        true        �������������
 *                          false       ��������������
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 * @version     1.0.0 (2006/09/20)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/04/05      xx-xxx      kajioka-h   shop_id�����Ǥ���褦�ˤ��ޤ���
 */
function Check_Payment_Close_Day($db_con, $client_id, $y, $m, $d, $shop_id=""){
    
    $sql  = "SELECT\n";
    $sql .= "   COALESCE(MAX(payment_close_day), '".START_DAY."') \n";
    $sql .= "FROM\n";
    $sql .= "   t_schedule_payment\n";
    $sql .= "WHERE\n";
    $sql .= "   client_id = $client_id\n";
    if($shop_id != ""){
        $sql .= "   AND \n";
        $sql .= "   shop_id = $shop_id \n";
    }
    $sql .= ";\n";
    $result = Db_Query($db_con, $sql);

    $payment_close_day = pg_fetch_result($result, 0,0);

//�ƥ��ȥǡ���
//$payment_close_day = '2006-09-01';

    //�������Ϥ��줿���դ���
    $m = str_pad($m, 2, 0, STR_PAD_LEFT);
    $d = str_pad($d, 2, 0, STR_PAD_LEFT);
    $pram_date = $y."-".$m."-".$d;

    //��Ф������դ��Ϥ��줿���դ���礭�����ϥ��顼
    if($payment_close_day >= $pram_date){
        return false;
    }
    return true;
}

/**
 *
 * �����ۡ����շ׻�
 *
 * @param       resource    $db_con         DB��³�꥽����
 * @param       int         $client_id      �����ID
 * @param       int         $total_money    ����
 * @param       int         $y              ���ǯ����������������ǯ���������Ȼ�������ǯ��
 * @param       int         $m              ������������������η�������Ȼ������η��
 * @param       int         $pay_out_div    1�����  2������
 * @param       int         $division_num   ������
 *
 * @return      array       [0][0]             1���ܤ�����
 *                          [0][1]��           2���ܰʹߤ�����
 *                          [1][0]             1���ܤ�����
 *                          [1][1]��           2���ܰʹߤ�����
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/09/16)
 *
 */
function Division_Price($db_con, $client_id, $total_money, $y, $m, $pay_out_div=1, $division_num=2)
{

    //�����λ�ʧ���ʽ������ˤ����
    if($pay_out_div == 1){
        $sql = "SELECT pay_m, pay_d FROM t_client WHERE client_id = $client_id;";
    }else{
        $sql = "SELECT payout_m, payout_d FROM t_client WHERE client_id = $client_id;";
    }
    $result = Db_Query($db_con, $sql);
    //$pay_m = (int)pg_fetch_result($result, 0, 0);
    $pay_m = date("m"); // ���ߤη�
    $pay_d = (int)pg_fetch_result($result, 0, 1);

    // �ǹ���ۡ�ʬ�����ξ�
    $division_quotient_price = bcdiv($total_money, $division_num);
    // �ǹ���ۡ�ʬ������;��
    $division_franct_price   = bcmod($total_money, $division_num);
    // 2���ܰʹߤβ�����
    $second_over_price       = str_pad(substr($division_quotient_price, 0, 3), strlen($division_quotient_price), 0);
    // 1���ܤβ�����
    $first_price             = ($division_quotient_price - $second_over_price) * $division_num + $division_franct_price + $second_over_price;

    // ��ۤ�ʬ�����ǳ���ڤ����
    if ($division_franct_price == "0"){
        $first_price = $second_over_price = $division_quotient_price;
    }  

    for($i=0;$i<$division_num;$i++){
        //����
        if($i==0){
            $price_array[0][0] = $first_price;
        }else{
            $price_array[0][$i] = $second_over_price;
        }

/*
        //����
        //�����ξ��
        if($pay_d == 29){
            $last_day = date("t", mktime(0, 0, 0, (int)$m + $pay_m + $i + 1, 1, (int)$y));
        }else{
            $last_day = $pay_d;
        }
        $price_array[1][$i] = date("Y-m-d", mktime(0, 0, 0, (int)$m + $pay_m + $i + 1 , $last_day, (int)$y));
*/

        // ʬ���ʧ������
        $date_y     = date("Y", mktime(0, 0, 0, $pay_m + $i, 1, $y));
        $date_m     = date("m", mktime(0, 0, 0, $pay_m + $i, 1, $y));
        $mktime_m   = ($pay_d == "29") ? $pay_m + $i + 1 : $pay_m + $i;
        $mktime_d   = ($pay_d == "29") ? 0 : $pay_d;
        $date_d     = date("d", mktime(0, 0, 0, $mktime_m, $mktime_d, $y));

        $price_array[1][$i] = date("Y-m-d", mktime(0, 0, 0, (int)$date_m, (int)$date_d, (int)$date_y));
    }

    return $price_array;
}


/**
 *
 * ���դ������ƥ೫�����夫�����å�
 *
 * @param       string      $y          �����å��������դ�ǯ
 *                          $m          �����å��������դη�
 *                          $d          �����å��������դ���
 *                          $label      ���顼��å������˽��Ϥ���̾��
 *
 * @return      str                     ���顼��å�����
 *
 * @author      ��
 * @version     1.0.0 (2006/10/04)
 *
 */
function Sys_Start_Date_Chk($y, $m, $d, $label){

    // �������Ϥ������ƿ��ͤξ��
    if (($y != null && $m != null && $d != null) && (ereg("^[0-9]+$", $y) && ereg("^[0-9]+$", $m) && ereg("^[0-9]+$", $d))){
        // 0���
        $y = str_pad($y, 4, "0", STR_PAD_LEFT);
        $m = str_pad($m, 2, "0", STR_PAD_LEFT);
        $d = str_pad($d, 2, "0", STR_PAD_LEFT);
        // �����ƥ೫������ʬ��ʥ��顼��å������ѡ�
        $ary_sys_date = explode("-", START_DAY);
        // �����ƥ೫���������Ƚ��
        if ($y."-".$m."-".$d < START_DAY){
            return "$label ��".(int)$ary_sys_date[0]."ǯ".(int)$ary_sys_date[1]."��".(int)$ary_sys_date[2]."������������դ����ϤǤ��ޤ���";
        }else{
            return;
        }
    }else{
        return;
    }

}

/**
 *
 * ��������ơ��֥�γ����쥳���ɤ�¸�ߤ��Ƥ��뤫Ƚ�ꤹ��
 * 
 * @param       resource    $db_con         DB��³�꥽����
 *                          $table          talbe̾
 *                          $column         �����̾
 *                          $p_id           �ץ饤�ޥꥭ��
 *                          $enter_day      ��Ͽ��  
 *
 * @return      boolean     true            ¸�ߤ�����
 *                          false           ¸�ߤ��ʤ����
 * @autor       ������
 * @version     1.00 (2006/10/07)
 *
 *
 *
**/
function Update_Check($db_con, $table, $column, $p_id, $enter_day){

    //��Ͽ���ȥץ饤�ޥꥭ���򥭡��Ȥ��ƥ쥳���ɿ��򥫥����
    $sql  = "SELECT ";
    $sql .= "   COUNT(*) ";
    $sql .= "FROM ";
    $sql .= "   ".$table." ";
    $sql .= "WHERE ";
    $sql .= "   enter_day = '".$enter_day."' ";
    $sql .= "AND ";
    $sql .= "   ".$column." = $p_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0,0);

    //�����쥳���ɤ�������
    if($row_num > 0){
        return true;
    //�����쥳���ɤ��ʤ����
    }else{
        return false;
    }
}

/**
 *
 * ��������ơ��֥�γ����쥳���ɤ�������������Ƥ��뤫Ƚ�ꤹ��
 * 
 * @param       resource    $db_con         DB��³�꥽����
 *                          $table          talbe̾
 *                          $column         �����̾
 *                          $p_id           �ץ饤�ޥꥭ��
 *
 * @return      boolean     true            ��������̤�»ܤξ���OK�ʾ���
 *                          false           ���������»ܺѤξ���NG�ξ���
 * @autor       ��
 * @version     1.00 (2006/10/30)
 *
**/
function Renew_Check($db_con, $table, $column, $p_id){

    //��Ͽ���ȥץ饤�ޥꥭ���򥭡��Ȥ��ƥ쥳���ɿ��򥫥����
    $sql  = "SELECT ";
    $sql .= "   COUNT(*) ";
    $sql .= "FROM ";
    $sql .= "   ".$table." ";
    $sql .= "WHERE ";
    $sql .= "   ".$column." = $p_id ";
    $sql .= "AND ";
    $sql .= "   renew_flg = 'f' ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0,0);

    //�����쥳���ɤ�������
    if($row_num > 0){
        return true;
    //�����쥳���ɤ��ʤ����
    }else{
        return false;
    }

}

/**
 * ���ס����դ�������������å����ޤ���
 *
 * ���������δؿ���HTML_QuickForm��registerRule�Ǥ����Ѥ�����˺������Ƥ��ޤ���
 *     �����Τ��ᡢ���פʰ����������Ĥ�¸�ߤ��ޤ���
 *
 * @param string    $val1   ����
 * @param string    $val2   ����
 * @param array     $date   �����å��������ա�ǯ������ν��
 *
 * @return boolean          �����Ǥʤ����դξ���false���֤��ޤ���
 */
//���ե����å��ؿ����ɲ�
function Check_Date($val1, $val2, $date){

    //���դ����
    $yy = array_shift($date);
    $mm = array_shift($date);
    $dd = array_shift($date);
    
    //���դ����Ϥ���Ƥ��ʤ����ϥ����å����ʤ���
    if($yy == "" && $mm == "" && $dd == ""){
        return true;
    }

    //���ͥ����å�
    if (!preg_match("/^[0-9]+$/", $yy)) {
        return false;
    }

    if (!preg_match("/^[0-9]+$/", $mm)) {
        return false;
    }

    if (!preg_match("/^[0-9]+$/", $dd)) {
        return false;
    }

    //���ե����å��»�
    if(checkdate($mm,$dd,$yy)){
      return true;
    }else{
        return false;
    }
    
} 


/**
 * ���ס�HTML_QuickForm�����Ѥ������դ����ϥե������������ޤ���
 *
 * ������ǯ������Υե�����̾�����ꤵ��ʤ���硢y��m��d�Ȥʤ�ޤ��� 
 *
 * @param object    $form      HTML_QuickForm���֥�������
 * @param string    $form_name HTML�ǤΥե�����̾
 * @param string    $label     ɽ��̾
 * @param string    $ifs       ���ڤ�ʸ��
 * @param string    $yy        ǯ�Υե�����̾
 * @param string    $mm        ��Υե�����̾
 * @param string    $dd        ���Υե�����̾
 *
 */
function Addelement_Date($form, $form_name, $label="", $ifs="", $yy="y", $mm="m", $dd="d",$option=""){

    //ǯ�ȷ�Υե�����̾�ʼ�ư�ե��������Τ���˻��ѡ�
    $form_y = "$form_name"."[".$yy."]";
    $form_m = "$form_name"."[".$mm."]";
    $form_d = "$form_name"."[".$dd."]";

    //ǯ
    $form_option = "class=\"ime_disabled\"".$option;
    $form_data[] =& $form->createElement("text", "$yy", "", "
    size=\"4\" maxLength=\"4\" 
    onkeyup=\"changeText(this.form,'$form_y', '$form_m', '4')\" 
    onKeyDown=\"chgKeycode();\" 
    onfocus=\"onForm_today(this,this.form,'$form_y','$form_m','$form_d')\" 
    onBlur=\"blurForm(this)\"
    $form_option
    ");

    //��
    $form_data[] =& $form->createElement("text", "$mm", "", "
    size=\"1\" maxLength=\"2\" 
    onkeyup=\"changeText(this.form,'$form_m', '$form_d', '2')\" 
    onKeyDown=\"chgKeycode();\" 
    onfocus=\"onForm_today(this,this.form,'$form_y','$form_m','$form_d')\" 
    onBlur=\"blurForm(this)\" 
    $form_option"
    );

    //��
    $form_data[] =& $form->createElement("text", "$dd", "", "
    size=\"1\" maxLength=\"2\" 
    onKeyDown=\"chgKeycode();\" 
    onfocus=\"onForm_today(this,this.form,'$form_y','$form_m','$form_d')\" 
    onBlur=\"blurForm(this)\" 
    $form_option"
    );
    
    $obj = $form->addGroup($form_data, $form_name, $label, $ifs);  

    return $obj;
}





/**
 *
 * ��������奨�顼�����å��ؿ�
 * 
 * @param       int         $goods_id       ����ID
 *              string      $goods_cd       ���ʥ�����
 *              string      $goods_name     ����̾
 *              int         $num            ����
 *              int         $price          ñ��  
 *              int         $amount         ���  
 *              string      $del_row        �������    
 *              int         $max_row        ����Կ�
 *              string      $type           ��ʬ
 *              
 *
 * @return      array       $return_array   �������
 *              
 * @autor       ������
 * @version     1.00 (2006/10/07)
 *
 *
 * 2009/09/04   aoyama-n    �Ͱ�����ۤ����ϤǤ���褦�˥ޥ��ʥ��ͤ����
 * 2009/09/16   kajioka-h   �������ϥ��ե饤����˿��̥����å����ʤ��褦���ѹ�
 *
**/
function Row_Data_Check2($check_ary){

    //�����Ȥ����Ϥ��줿������Ѥ�򤽤줾���ѿ��˥ǡ������Ǽ
    $goods_id       = $check_ary[0];            //����ID
    $goods_cd       = $check_ary[1];            //���ʥ�����
    $goods_name     = $check_ary[2];            //����̾
    $sale_num       = $check_ary[3];            //���������вٿ�
    $cost_price     = $check_ary[4];            //����ñ��
    $sale_price     = $check_ary[5];            //���ñ��
    $cost_amount    = $check_ary[6];            //�������
    $sale_amount    = $check_ary[7];            //�����
    $tax_div        = $check_ary[8];            //���Ƕ�ʬ
    $del_row        = $check_ary[9];            //�������
    $max_row        = $check_ary[10];           //����Կ�
    $type           = $check_ary[11];           //����������ʬ
    $db_con         = $check_ary[12];           //DB���ͥ������
    $aord_num       = $check_ary[13];           //������
    $royalty        = $check_ary[14];           //�������ƥ�
    //aoyama-n 2009-09-04
    $discount_flg   = $check_ary[15];           //�Ͱ��ե饰


    //���顼��å�����Ƚ��
    //if($type == 'aord'){
	//rev.1.2 kajioka-h 2009/09/16
    if($type == 'aord' || $type == 'aord_offline'){
        $type_name = "����";
    }elseif($type == 'sale'){
        $type_name = "�в�";
    }

    //�Կ�
    $line = 0;
    //��Ͽ�ǡ������󥭡�
    $j = 0;

    //ɽ���Կ�ʬ�롼��
    for($i = 0; $i < $max_row; $i++){

        //����Ԥ�����н賰�Ȥ���
        if(!in_array("$i", $del_row)){

            //�����å������NO
            $line = $line+1;

            //�������ϥ����å�
            if($goods_cd[$i] != null){

                if(ereg("^[0-9]+$",$goods_cd[$i]) && $goods_id[$i] != null){

                    $goods_id[$i] = ($goods_id[$i] != null)? $goods_id[$i] : "null";

                    //��Ͽ�ܥ��󲡲����˾��ʥ����ɤ��ѹ�����Ƥ��ʤ��������å�
                    $sql  = "SELECT";
                    $sql .= "   COUNT(goods_id) ";
                    $sql .= "FROM";
                    $sql .= "   t_goods ";
                    $sql .= "WHERE";
                    $sql .= "   goods_id =  $goods_id[$i]";
                    $sql .= "   AND";
                    $sql .= "   goods_cd = '$goods_cd[$i]'";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);
                    $count = pg_fetch_result($result, 0,0);

                    $input_flg[$i] = true;
                    //��äƤ������
                    if($count != 1){
                        $goods_err[$i] = $line."���ܡ����ʾ���������� ".$type_name."��ǧ���̤إܥ��󤬲�����ޤ�����<br>������ľ���Ƥ���������";
                        $err_flg[$i] = true;
                    }

                }else{
                    $goods_err[$i] = $line."���ܡ����������ʥ����ɤ����Ϥ��Ʋ�������";
                    $err_flg[$i] = true;
                    continue;
                }

            }else{
                $input_flg[$i] = false;
            }

            //���ʤ����Ϥ���Ƥ�����
            if($input_flg[$i] == true){

                //���̤Ȼ���ñ�������Ϥ����뤫
                //if($sale_num[$i] == null || $cost_price[$i]["i"] == null || $sale_price[$i]["i"] == null){
				//rev.1.2 kajioka-h 2009/09/16
                if(($type != 'aord_offline' && ($sale_num[$i] == null || $cost_price[$i]["i"] == null || $sale_price[$i]["i"] == null)) ||
				   ($type == 'aord_offline' && ($cost_price[$i]["i"] == null || $sale_price[$i]["i"] == null))
				){
					if($type != 'aord_offline'){
	                    $price_num_err[$i] = $line."���ܡ�".$type_name."���Ϥ�".$type_name."���ȸ���ñ�������ñ����ɬ�ܤǤ���";
					}else{
	                    $price_num_err[$i] = $line."���ܡ�".$type_name."���Ϥ˸���ñ�������ñ����ɬ�ܤǤ���";
					}

                    $err_flg[$i] = true;
                    continue;

                //���̤Ȼ���ñ�������Ϥ�������
                }else{
					if($type != 'aord_offline'){
                    	//���̿�Ⱦ�ѿ��������å�
                    	if(!ereg("^[0-9]+$",$sale_num[$i]) || ($sale_num[$i] == null || $sale_num[$i] == 0)){
                        	$num_err[$i] = $line."���ܡ�".$type_name."����Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                        	$err_flg[$i] = true;
                    	}
					}

                    //aoyama-n 2009-09-04
                    /**************
                    //�����ξ��
                    if($type == aord){

                        //����Ⱦ�ѿ��������å�
                        if(($cost_price[$i]["i"] != null && !ereg("^[0-9]+$",$cost_price[$i]["i"])) 
                            || 
                            ($cost_price[$i]["d"] != null && !ereg("^[0-9]+$",$cost_price[$i]["d"]))
                        ){
                            $cost_price_err[$i] = $line."���ܡ�����ñ����Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }

                        //���Ⱦ�ѿ��������å�
                        if(($sale_price[$i]["i"] != null && !ereg("^[0-9]+$",$sale_price[$i]["i"])) 
                            || 
                            ($sale_price[$i]["d"] != null && !ereg("^[0-9]+$",$sale_price[$i]["d"]))
                        ){
                            $sale_price_err[$i] = $line."���ܡ����ñ����Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }
                    //���ξ��
                    }else{
                        //����Ⱦ�ѿ��������å�
                        if(($cost_price[$i]["i"] != null && !ereg("^[0-9]+$",$cost_price[$i]["i"])) 
                            || 
                            ($cost_price[$i]["d"] != null && !ereg("^[0-9]+$",$cost_price[$i]["d"]))
                        ){
                            $cost_price_err[$i] = $line."���ܡ�����ñ����Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }

                        //���Ⱦ�ѿ��������å�
                        if(($sale_price[$i]["i"] != null && !ereg("^[0-9]+$",$sale_price[$i]["i"])) 
                            || 
                            ($sale_price[$i]["d"] != null && !ereg("^[0-9]+$",$sale_price[$i]["d"]))
                        ){
                            $sale_price_err[$i] = $line."���ܡ����ñ����Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }
                        

                    }
                    **************/
                    //�Ͱ����ʤΥ����å�
                    if($discount_flg[$i] === 't'){ 
                        //����Ⱦ�ѿ��������å�
                        if(($cost_price[$i]["i"] != null && !ereg("^[-0-9]+$",$cost_price[$i]["i"])) 
                            || 
                            ($cost_price[$i]["d"] != null && !ereg("^[0-9]+$",$cost_price[$i]["d"]))
                        ){
                            $cost_price_err[$i] = $line."���ܡ�����ñ���ϡ�-�פ�Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }elseif ($cost_price[$i]["i"] > 0 ){
                            $cost_price_err[$i] = $line."���ܡ����ʤ��Ͱ�����ꤷ����硢����ñ���ϣ��ʲ��ο��ͤΤ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }

                        //���Ⱦ�ѿ��������å�
                        if(($sale_price[$i]["i"] != null && !ereg("^[-0-9]+$",$sale_price[$i]["i"])) 
                            || 
                            ($sale_price[$i]["d"] != null && !ereg("^[0-9]+$",$sale_price[$i]["d"]))
                        ){
                            $sale_price_err[$i] = $line."���ܡ����ñ����Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }elseif($sale_price[$i]["i"] > 0 ){
                            $sale_price_err[$i] = $line."���ܡ����ʤ��Ͱ�����ꤷ����硢���ñ���ϣ��ʲ��ο��ͤΤ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }
                    //�Ͱ����ʰʳ��Υ����å�
                    }else{
                        //����Ⱦ�ѿ��������å�
                        if(($cost_price[$i]["i"] != null && !ereg("^[0-9]+$",$cost_price[$i]["i"])) 
                            || 
                            ($cost_price[$i]["d"] != null && !ereg("^[0-9]+$",$cost_price[$i]["d"]))
                        ){
                            $cost_price_err[$i] = $line."���ܡ�����ñ����Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }

                        //���Ⱦ�ѿ��������å�
                        if(($sale_price[$i]["i"] != null && !ereg("^[0-9]+$",$sale_price[$i]["i"])) 
                            || 
                            ($sale_price[$i]["d"] != null && !ereg("^[0-9]+$",$sale_price[$i]["d"]))
                        ){
                            $sale_price_err[$i] = $line."���ܡ����ñ����Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                            $err_flg[$i] = true;
                        }
                    }

                }

                //��Ͽ�ǡ�������
                $add_data[goods_id][$j]     = $goods_id[$i];                                        //����ID              
                $add_data[goods_cd][$j]     = $goods_cd[$i];                                        //����CD              
                $add_data[goods_name][$j]   = $goods_name[$i];                                      //����̾           
                $add_data[sale_num][$j]     = $sale_num[$i];                                        //����             
                $add_data[cost_price][$j]   = $cost_price[$i][i].".".$cost_price[$i][d];            //����ñ��
                $add_data[sale_price][$j]   = $sale_price[$i][i].".".$sale_price[$i][d];            //���ñ��
                $add_data[cost_amount][$j]  = str_replace(',','',$cost_amount[$i]);                 //�������
                $add_data[sale_amount][$j]  = str_replace(',','',$sale_amount[$i]);                 //�����
                $add_data[tax_div][$j]      = $tax_div[$i];                                         //���Ƕ�ʬ              
                $add_data[aord_num][$j]     = $aord_num[$i];                                        //����             
                $add_data[royalty][$j]      = $royalty[$i];                                         //�������ƥ�            
                $add_data[def_line][$j]     = $line;
                //��Ͽ������
                $j++;

            //���ʤ����򤵤�Ƥ��ʤ��Τˡ����̡�ñ���Τ����줫�����Ϥ�������
            }elseif(($goods_cd[$i] == null 
                    || 
                    $goods_name[$i] == null)
                    && 
                    ($sale_price[$i]["i"] != null 
                    || 
                    $sale_price[$i]["d"] != null
                    ||
                    $cost_price[$i]["i"] != null
                    ||
                    $cost_price[$i]["d"] != null
                    ||
                    $sale_num[$i] != null)
            ){
                $price_num_err[$i] = $line."���ܡ����ʤ����򤷤Ʋ�������";
                $err_flg[$i] = true;
                $err_input_flg = true;
                continue;
            }
        }
    }

    //�������Ϥ��ʤ����
    if(!@in_array(true, $input_flg) && $err_input_flg != true){
        $no_goods_err = "���ʤ���Ĥ����򤵤�Ƥ��ޤ���";
        $err_flg[] = true;
    }

    //���顼�����ä����
    if(@in_array(true, $err_flg)){
        $return_array = array(true, $no_goods_err, $goods_err, $price_num_err, $num_err, $cost_price_err, $sale_price_err);
    }else{
        $return_array = array(false, $add_data);
    }

    return $return_array;
}

/**
 * ���ס������å��ܥå������������å���Ԥʤ�javascript��������ޤ���
 *
 * ������HTML_QuickForm��advcheckbox�Ǻ������줿�����å��ܥå����Ѥδؿ��Ǥ���
 *
 * ����????/??/??������������<morita-d>
 * ������2007/01/30���̾�Υ����å��ܥå����ˤ��б�����褦���ѹ���<watanabe-k>
 *
 * @param string    $function_name   javascript�δؿ�̾
 * @param string    $name            �������å���������å��ܥå���̾
 *
 * @return string          �������å���javascript
 */
function Create_Allcheck_Js ($function_name, $name, $data, $type=null) {

  if (is_array($data)) {
        while ($val = each($data)) {

            $line        = $val[0];
            $bill_id     = $val[1];

            //�̾�Υ����å��ܥå����ξ��
            if($type == '1'){
                $f_name_val  = $name."[".$bill_id."]";

                $js_parts1 .= "         document.forms[0].elements[\"$f_name_val\"].checked = true; \n";
                $js_parts2 .= "         document.forms[0].elements[\"$f_name_val\"].checked = false; \n";

            //advcheckbox�ξ��
            }else{
                $f_name_val  = $name."[".$line."]";
                $f_name_chk  = "__".$name."[".$line."]";

                $js_parts1 .= "         document.forms[0].elements[\"$f_name_val\"].value = \"$bill_id\";\n ";
                $js_parts1 .= "         document.forms[0].elements[\"$f_name_chk\"].checked = true; \n";
                
                $js_parts2 .= "         document.forms[0].elements[\"$f_name_val\"].value = \"f\";\n ";
                $js_parts2 .= "         document.forms[0].elements[\"$f_name_chk\"].checked = false; \n";
            }

        }       
    }
    $javascript = "
    function $function_name (all_name) {
        var ALL = all_name;
        if(document.forms[0].elements[ALL].checked == true){
            $js_parts1
        }else{
            $js_parts2
        }
    }
    ";

    return $javascript;
}


/**
 * ���� ���ͤ򥫥�޶��ڤ���Ѵ����ޤ���
 *
 * ���� �ޥ��ʥ����ͤ�Ϳ����줿��硢��ʸ����ɽ�����ޤ���
 *
 * @param integer     $int   ����
 * 
 * @return string HTML�ǡ���
 *
 */
function Minus_Numformat ($int) {

	if ($int < 0) {
		$int = "<font color=\"red\">".number_format($int)."</font>";
	} else {
		$int = number_format($int);
	}

	return $int;
}

/**
 *
 * ��������ơ��֥�γ����쥳���ɤ��ѹ�����Ƥ��뤫��ǧ����
 * 
 * @param       resource    $db_con         DB��³�꥽����
 *                          $table          talbe̾ 
 *                          $column         �����̾
 *                          $p_id           �ץ饤�ޥꥭ��
 *
 * @return      boolean     true            ¸�ߤ�����
 *                          false           ¸�ߤ��ʤ����
 * @autor       ������  
 * @version     1.00 (2006/10/07)
 *
 *
 *
**/
function Finish_Check($db_con, $table, $column, $p_id){

    //��Ͽ���ȥץ饤�ޥꥭ���򥭡��Ȥ��ƥ쥳���ɿ��򥫥����
    $sql  = "SELECT ";
    $sql .= "   COUNT(*) ";
    $sql .= "FROM ";
    $sql .= "   ".$table." ";
    $sql .= "WHERE ";
    $sql .= "   ps_stat = '1'";
    $sql .= " AND "; 
    $sql .= "   ".$column." = $p_id ";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0,0);

    //�����쥳���ɤ�������
    if($row_num > 0){
        return true;
    //�����쥳���ɤ��ʤ����
    }else{  
        return false;
    }
}

/**
 *
 * ��������ơ��֥�γ����쥳���ɤ��ѹ�����Ƥ��뤫��ǧ���� * 
 * @param       resource    $db_con         DB��³�꥽����
 *                          $table          talbe̾ 
 *                          $column         �����̾
 *                          $p_id           �ץ饤�ޥꥭ��
 *                          $change_day     �ץ饤�ޥꥭ��
 *
 * @return      boolean     true            ¸�ߤ�����
 *                          false           ¸�ߤ��ʤ����
 * @autor       ������  
 * @version     1.00 (2006/10/07)
 *
 *
 *
**/
function Update_Data_Check($db_con, $table, $column, $p_id, $change_day){ 

    //��Ͽ���ȥץ饤�ޥꥭ���򥭡��Ȥ��ƥ쥳���ɿ��򥫥����
    $sql  = "SELECT ";
    $sql .= "   COUNT(*) ";
    $sql .= "FROM ";
    $sql .= "   ".$table." ";
    $sql .= "WHERE ";
    $sql .= "   change_day = '$change_day'"; 
    $sql .= " AND ";  
    $sql .= "   ".$column." = $p_id ";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0,0);

    //�����쥳���ɤ�������
    if($row_num > 0){
        return true;
    //�����쥳���ɤ��ʤ����
    }else{  
        return false;
    }
}


/**
 * �᡼�������ؿ�
 *
 * �ѹ�����
 * 1.0.0 (2006/11/17) ��������(suzuki-t)
 *
 * @version     1.0.0 (2006/11/17)
 *
 * @param               string      $mail_flg     ����Ƚ�� 
 * @param               string      $address      ���ɥ쥹 
 * @param               string      $subject      ��̾   
 * @param               string      $contents     ��ʸ   
 *                                  
 *
 *                                  
 */
function Error_send_mail($mail_flg,$address,$subject,$contents){ 

	//����Ƚ��
	if($mail_flg == true){
	    //����λ�����������󥳡��ǥ���
		mb_language("Ja"); 
		mb_internal_encoding("EUC");
		mb_send_mail($address,$subject,$contents);
	}
}


/**
 * �����Ҹ���дؿ�
 *
 *
 * �ѹ�����
 * 1.0.0 (2007/02/21) �������� ��watanabe-k��
 *
 * @version     1.0.0(2007/02/21)
 *
 * @param                         $db_con        �꥽����
 * @param                         $branch_id     ��ŹID
 *
 *
 *
 *
 */
function Get_Ware_Id($db_con, $branch_id){

    $sql  = "SELECT \n";
    $sql .= "   bases_ware_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_branch \n";
    $sql .= "WHERE \n";
    $sql .= "   branch_id = $branch_id \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    $num = pg_num_rows($result);

    if($num != 0){
        $ware_id = pg_fetch_result($result, 0,0);
        return $ware_id;
    }else{
        return ;
    }
}

/**
 * �����åդ�ô���Ҹ���дؿ�
 *
 *
 * �ѹ�����
 * 1.0.0 (2007/03/01) �������� ��kj��
 *
 * @version     1.0.0(2007/03/01)
 *
 * @param                         $db_con        �꥽����
 * @param                         $staff_id      �����å�ID
 *                                              �ʻ��ꤷ�ʤ����ϥ�������Ԥ�ID�Ȥʤ��
 *
 * @return      int     �������Ҹ�ID
 *                      ���ԡ��̤�
 *
 */
function Get_Staff_Ware_Id($db_con, $staff_id = null){

    $sql  = "SELECT \n";
    $sql .= "   ware_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "WHERE \n";
    if($staff_id == null){
        $sql .= "   staff_id = ".$_SESSION["staff_id"]." \n";
    }else{
        $sql .= "   staff_id = $staff_id \n";
    }
    $sql .= "   AND \n";
    $sql .= "   h_staff_flg = false \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    $num = pg_num_rows($result);

    if($num != 0){
        $ware_id = pg_fetch_result($result, 0,0);
        return $ware_id;
    }else{
        return ;
    }
}

/**
 * ��Ź��дؿ�
 *
 *
 * �ѹ�����
 * 1.0.0 (2007/02/21) �������� ��watanabe-k��
 * 1.1.0 (2007/02/27) �����å�ID������ǽ�� ��watanabe-k��
 *
 * @version     1.0.0(2007/02/21)
 *
 * @param                         $db_con        �꥽����
 * @param                         $staff_id      �����å�ID
 *                                              �ʻ��ꤷ�ʤ����ϥ�������Ԥ�ID�Ȥʤ��
 *
 *
 */
function Get_Branch_Id($db_con, $staff_id = null){

    $sql  = "SELECT ";
    $sql .= "   branch_id ";
    $sql .= "FROM ";
    $sql .= "   t_attach ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_part";
    $sql .= "   ON t_attach.part_id = t_part.part_id ";
    $sql .= "WHERE ";
    if($staff_id == null){
        $sql .= "   t_attach.staff_id = ".$_SESSION["staff_id"]." ";
    }else{
        $sql .= "   t_attach.staff_id = $staff_id ";
    }
    $sql .= "   AND";
    $sql .= "   t_attach.h_staff_flg = 'f' ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    $ware_id = pg_fetch_result($result, 0,0);
    return $ware_id;
}


/**
 * ���� �祭�����������ޤ�
 *
 * ���� �祭���������ˤϥޥ���������������Ѥ��ޤ���
 *
 * @return integer         �祭��
 */
function Get_Pkey(){
    $microtime   = explode(" ",microtime());
    $pkey = $microtime[1].substr("$microtime[0]", 2, 6);

    return $pkey;
}


/**
 * ����     �⥸�塼���ֹ�����ؿ�
 *
 * ����     �����̤Υ⥸�塼���ֹ���������
 *
 * @param   N/A
 *
 * @return  $module_no      �����̤Υ⥸�塼���ֹ�(../DIR/MODULE.php)
 */
function Get_Mod_No(){

    $explode_url    = explode("/", $_SERVER["PHP_SELF"]);
    $count          = count($explode_url);
    $module_no      = "../".$explode_url[$count-2]."/".$explode_url[$count-1];

    // �⥸�塼���ֹ���֤�
    return $module_no;

}


/**
 * ����     ��������Ȥ��Ƽ��⥸�塼���SESSION�˥��å�
 *
 * ����     �������������Ϣ
 *
 * @param   $type           �����̤�°����ʬ��ʼ�������塢ȯ�������������⡢��ʧ�����������
 *                          ʣ����ʬ���°���Ƥ����������ǵ��ҡ���. ȯ���Ĥ�ȯ����ɼ�ѹ��Ȼ������Ϥ��Ԥ���Τ�ȯ���Ȼ�����°�����
 *          $search_flg     ������������������⥸�塼��ξ���true����ꤹ��
 *
 * @return  void
 */
function Set_Rtn_Page($type, $search_flg = null){

    // �����̤�����/FC�����׼���
    $hf = ($_SESSION["group_kind"] == "1") ? "h" : "f";

    // ʬ�ब����ξ��
    if (is_array($type) == true){
        // ���줾���ʬ���SESSION�˥��å�
        foreach ($type as $key => $value){
            $_SESSION[$hf][$value]["return_page"]["page"]   = Get_Mod_No();
            $_SESSION[$hf][$value]["return_page"]["get"]    = ($search_flg == true) ? "?search=1" : "";
        }
    // ʬ�ब����Ǥʤ����
    }else{
        // ���ꤵ�줿ʬ���SESSION�˥��å�
        $_SESSION[$hf][$type]["return_page"]["page"]    = Get_Mod_No();
        $_SESSION[$hf][$type]["return_page"]["get"]     = ($search_flg == true) ? "?search=1" : "";
    }

}


/**
 * ����     SESSION�λ��ꤵ�줿���������äƤ������������֤�
 *
 * ����     ��λ���̤�OK�ܥ������ٲ��̤����ܥ���ʤɤ�������˻���
 *
 * @param   $type           �����̤�°����ʬ��ʼ�������塢ȯ�������������⡢��ʧ�����������
 *          $search_flg     ������������������⥸�塼��ξ���true����ꤹ��
 *
 * @return  void
 */
function Make_Rtn_Page($type){

    // �����̤�����/FC�����׼���
    $hf = ($_SESSION["group_kind"] == "1") ? "h" : "f";

    return $_SESSION[$hf][$type]["return_page"]["page"].$_SESSION[$hf][$type]["return_page"]["get"];

}


/**
 * ����     ���������������
 *
 * ����     ���������������������Ȳ���̤�ɬ�����Ȥ�����
 *
 * @param   $form           �ե����४�֥�������
 *          $type           �����̤�°����ʬ�������ǵ��ҡʼ�������塢ȯ�������������⡢��ʧ�����������
 *                          ����. ȯ���İ�����ȯ����ɼ�ѹ��Ȼ������Ϥ��Ԥ���Τ�ȯ���Ȼ�����°���� -> array("ord", "sale") ��
 *                          ����Ȳ�Τ褦��1�Ĥ���°���Ƥ��ʤ���������ˤ��ʤ��Ƥ�OK�Ǥ�
 *          $disp_btn       ��ɽ���ץܥ����̾��
 *          $ary_form_list  �������ܤȽ���ͤΥꥹ��
 *          $ary_pass_list  ����������������ڡ������ڤ��ؤ����˥��åȤ���POST�ǡ����ꥹ�ȡ�����ˤʤäƤ���ե������̤�б���
 *
 * @return  void
 */
function Restore_Filter2($form, $type, $disp_btn, $ary_form_list, $ary_pass_list = null){

    // �ڡ����ڤ��ؤ��ե饰���å���hidden
    $form->addElement("hidden", "switch_page_flg");

    // �����̤Υ⥸�塼���ֹ����
    $module_no = Get_Mod_No();

    // �����Ƚ�򥻥å����˥��åȡʾ����
    if ($_POST["hdn_sort_col"] != null){
        $_SESSION[$module_no]["all"]["hdn_sort_col"]    = $_POST["hdn_sort_col"];
        $_SESSION[$module_no]["search"]["hdn_sort_col"] = $_POST["hdn_sort_col"];
    }

    // �����̤�����/FC�����׼���
    $hf = ($_SESSION["group_kind"] == "1") ? "h" : "f";

    // ��������SESSION�˼��⥸�塼�뤬���뤫Ĵ�٤�
    // �����$return_flg��true�򥻥å�
    if (is_array($type) == true){
        foreach ($type as $key => $value){
            if ($_SESSION[$hf][$value]["return_page"]["page"] == $module_no){
                $return_flg = true;
                break;
            }
        }
    }else{
        $return_flg = ($_SESSION[$hf][$type]["return_page"]["page"] == $module_no) ? true : false;
    }

    // �����ܻ��ʺ�������SESSION�˼��⥸�塼�뤬����ܸ���GET���������
    if ($return_flg == true && $_GET["search"] == "1"){

        // �������SESSION(all)��POST������
        $_POST = $_SESSION[$module_no]["all"];

        // ����������������ꥹ�Ȥǥ롼��
        if (count($ary_pass_list) > 0){
            foreach ($ary_pass_list as $key => $value){
                // �ե������POST�򸡺�������������ꥹ�Ȥ��ͤǾ��
                $_POST[$key] = $value;
            }
        }

        // $_POST������С��ե����ॻ�å��Ѥ��ͤ�stripslashes
        $ss_to_form = (count($_POST) > 0) ? Ary_Foreach($_POST, "stripslashes") : null;

        // �ͤ�ե�����˥��å�
        $form->setConstants($ss_to_form);

    // �ڡ����ڤ��ؤ���������POST����ɽ���ܥ���̤������ɽ���ܥ���ʳ���POST�������
    }elseif ($_POST[$disp_btn] == null && $_POST != null){

        // �������SESSION(hidden)��������
        if (count($_SESSION[$module_no]["search"]) > 0){

            // �������SESSION(hidden)��POST�ȥե����ॻ�å������������
            foreach ($_SESSION[$module_no]["search"] as $key => $value){
                $_POST[$key]        = $value; 
                $ss_to_form[$key]   = $value; 
            }

            // ���Ϸ�������Ģɼ�ס�CSV�פξ��
            if ($_POST["form_output_type"] == "2" || $_POST["form_output_type"] == "3"){
                // ���Ϸ�����POST�ͤ�ֲ��̡פ˥��å�
                $_POST["form_output_type"]      = "1";
                $ss_to_form["form_output_type"] = "1";
            }

            // �ե����ॻ�å��Ѥ��ͤ�stripslashes
            $ss_to_form = Ary_Foreach($ss_to_form, "stripslashes");
            $form->setConstants($ss_to_form);

        // �������SESSION(hidden)���ʤ����
        }else{  

            // ����������ͤ�POST�ȥե����ॻ�å������������
            foreach ($ary_form_list as $key => $value){
                $_POST[$key] = $def_to_form[$key] = $value; 
            }
            $form->setConstants($def_to_form);

        }

        // POST���줿�ڡ�������SESSION(all)�˥��å�
        // �����ܻ��Υڡ����������˻���
        Post_To_Session($ary_form_list, "page");

        // �ڡ����ڤ��ؤ��ե饰�򥯥ꥢ
        $clear_hdn["switch_page_flg"] = "";
        $form->setConstants($clear_hdn);

    // ɽ���ܥ��󲡲���
    }elseif ($_POST[$disp_btn] != null){

        // �������ܤ�POST��SESSION(all)�˥��å�
        // �����ܻ��θ�����������˻���
        Post_To_Session($ary_form_list);

        // �������ܤ�POST��SESSION(hidden)�˥��å�
        // �ڡ����ڤ��ؤ�����������POST���θ�����������˻���
        Post_To_Session($ary_form_list, "search");

        // �ڡ�����POST�򥢥󥻥åȡ�1�ڡ����ܤ�ɽ�������뤿���
        unset($_POST["f_page1"]);
        unset($_POST["f_page2"]);

    }

    // POST���ʤ���GET��̵�����
    if ($_POST == null && $_GET["search"] == null){
        // SESSION�˴�
        $_SESSION[$module_no] = null;
    }

    // ��������Ȥ��Ƽ��⥸�塼���SESSION�˥��å�
    Set_Rtn_Page($type, true);

}


/**
 * ����     ���������������
 *
 * ����     ���������������������Ȳ���̤�ɬ�����Ȥ�����
 *
 * @param   $form           �ե����४�֥�������
 *          $disp_btn       ��ɽ���ץܥ����̾��
 *          $ary_form_list  �������ܤȽ���ͤΥꥹ��
 *          $ary_pass_list  ������������ν���POST̾�ꥹ�ȡ�����ˤʤäƤ���ե������̤�б���
 *
 * @return  void
 */
function Restore_Filter($form, $disp_btn, $ary_form_list, $ary_pass_list = null){

    // �ڡ����ڤ��ؤ��ե饰���å���hidden
    $form->addElement("hidden", "switch_page_flg");

    // �����̤Υ⥸�塼���ֹ����
    $module_no = Get_Mod_No();

    // �����ܻ��ʺ������褬�����̡ܸ���GET���������
    if ($module_no == $_SESSION["return_page"]["page"] && $_GET["search"] == "1"){

        // �������SESSION(all)��POST������
        $_POST = $_SESSION[$module_no]["all"];

        // ����������������ꥹ�Ȥǥ롼��
        if (count($ary_pass_list) > 0){
            foreach ($ary_pass_list as $key => $value){
                // �ե������POST�򸡺�������������ꥹ�Ȥ��ͤǾ��
                $_POST[$key] = $value;
            }
        }

        // $_POST������С��ե����ॻ�å��Ѥ��ͤ�stripslashes
        $ss_to_form = (count($_POST) > 0) ? Ary_Foreach($_POST, "stripslashes") : null;

        // �ͤ�ե�����˥��å�
        $form->setConstants($ss_to_form);

    // �ڡ����ڤ��ؤ���������POST����ɽ���ܥ���̤������ɽ���ܥ���ʳ���POST�������
    }elseif ($_POST[$disp_btn] == null && $_POST != null){

        // �������SESSION(hidden)��������
        if (count($_SESSION[$module_no]["search"]) > 0){

            // �������SESSION(hidden)��POST�ȥե����ॻ�å������������
            foreach ($_SESSION[$module_no]["search"] as $key => $value){
                $_POST[$key]        = $value; 
                $ss_to_form[$key]   = $value; 
            }
            // �ե����ॻ�å��Ѥ��ͤ�stripslashes
            $ss_to_form = Ary_Foreach($ss_to_form, "stripslashes");
            $form->setConstants($ss_to_form);

        // �������SESSION(hidden)���ʤ����
        }else{  

            // ����������ͤ�POST�ȥե����ॻ�å������������
            foreach ($ary_form_list as $key => $value){
                $_POST[$key] = $def_to_form[$key] = $value; 
            }       
            $form->setConstants($def_to_form);

        }

        // POST���줿�ڡ�������SESSION(all)�˥��å�
        // �����ܻ��Υڡ����������˻���
        Post_To_Session($ary_form_list, "page");

        // �ڡ����ڤ��ؤ��ե饰�򥯥ꥢ
        $clear_hdn["switch_page_flg"] = "";
        $form->setConstants($clear_hdn);

    // ɽ���ܥ��󲡲���
    }elseif ($_POST[$disp_btn] != null){

        // �������ܤ�POST��SESSION(all)�˥��å�
        // �����ܻ��θ�����������˻���
        Post_To_Session($ary_form_list);

        // �������ܤ�POST��SESSION(hidden)�˥��å�
        // �ڡ����ڤ��ؤ�����������POST���θ�����������˻���
        Post_To_Session($ary_form_list, "search");

        // �ڡ�����POST�򥢥󥻥åȡ�1�ڡ����ܤ�ɽ�������뤿���
        unset($_POST["f_page1"]);
        unset($_POST["f_page2"]);

    }

    // POST���ʤ���GET��̵�����
    if ($_POST == null && $_GET["search"] == null){
        // SESSION�˴�
        $_SESSION[$module_no] = null;
    }

    // ��������Ȥ��Ƽ��⥸�塼���ֹ��GET���ղä���ʸ�����SESSION�˥��å�
    $_SESSION["return_page"]["page"]  = "$module_no";
    $_SESSION["return_page"]["get"]   = "?search=1";

}


/**
 * ����     POST��SESSION�˥��å�
 *
 * ����     �ݥ��Ȥ򥻥å�����SET
 *
 * @param   $ary_form_list  �������ܤȽ���ͤ�����
 *          $type           SESSION�˥��åȤ���ѥ�����μ��̻�
 *                          null:POST���� search:�������ܤ�POST�Τ�  page:�ڡ�������POST�Τ�
 *
 * @return  void
 */
function Post_To_Session($ary_form_list, $type = null){

    // �����̤Υ⥸�塼���ֹ����
    $module_no = Get_Mod_No();

    if ($type == null){

        // ���Ƥ�POST��SESSION�˥��å�
        // ɽ���ܥ��󲡲����˹Ԥ�
        // �����ܻ��θ�����������˻���
        $_SESSION[$module_no]["all"] = $_POST;

    }elseif ($type == "search"){

        // �������ܤ�POST��SESSION�˥��å�
        // ɽ���ܥ��󲡲����˹Ԥ�
        // �ڡ����ڤ��ؤ�����������POST���θ�����������˻���
        foreach ($ary_form_list as $key => $value){
            $_SESSION[$module_no]["search"][$key] = $_POST[$key];
        }

    }elseif ($type == "page"){

        // �ڡ������Τ�SESSION�˥��å�
        // �ڡ����ڤ��ؤ����˹Ԥ���POST���줿�ڡ������Τ�SESSION���ݻ������뤿���
        // �����ܻ��Υڡ����������˻���
        $_SESSION[$module_no]["all"]["f_page1"] = $_POST["f_page1"];
        $_SESSION[$module_no]["all"]["f_page2"] = $_POST["f_page2"];

    }

}


/**
 * ����     HTML_QuickForm�����Ѥ������դ����ϥե������������ϰϡ�
 *
 * ����     ǯ������Υե�����̾�����ꤵ��ʤ���硢y, m, d�Ȥʤ�ޤ�
 *
 * @param object    $form       HTML_QuickForm���֥�������
 * @param string    $form_name  HTML�ǤΥե�����̾
 * @param string    $label      ɽ��̾
 * @param string    $ifs        ���ڤ�ʸ��
 * @param string    $yy         ǯ�Υե�����̾
 * @param string    $mm         ��Υե�����̾
 * @param string    $dd         ���Υե�����̾
 *
 */
function Addelement_Date_Range($form, $form_name, $label = "", $ifs = "", $yy = "y", $mm = "m", $dd = "d", $option = ""){

    // js�ѥե�����̾
    $form_sy    = "$form_name"."[s".$yy."]";
    $form_sm    = "$form_name"."[s".$mm."]";
    $form_sd    = "$form_name"."[s".$dd."]";
    $form_ey    = "$form_name"."[e".$yy."]";
    $form_em    = "$form_name"."[e".$mm."]";
    $form_ed    = "$form_name"."[e".$dd."]";

    // °����js
    $sizelen_y  = "size=\"4\" maxLength=\"4\" ";
    $sizelen_md = "size=\"1\" maxLength=\"2\" ";
    $onfocus_s  = "onfocus=\"onForm_today(this, this.form, '$form_sy', '$form_sm', '$form_sd');\" ";
    $onfocus_e  = "onfocus=\"onForm_today(this, this.form, '$form_ey', '$form_em', '$form_ed');\" ";
    $onblur     = "onBlur=\"blurForm(this);\" ";
    $onkeydown  = "onKeyDown=\"chgKeycode();\" ";
    $form_option= "class=\"ime_disabled\" ".$option;

    $obj = null; 

    // ǯ�ʳ��ϡ�
    $obj[] =& $form->createElement("text", "s$yy", "", "
        onkeyup=\"changeText(this.form, '$form_sy', '$form_sm', '4');\"
        $sizelen_y $onfocus_s $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    // ��ʳ��ϡ�
    $obj[] =& $form->createElement("text", "s$mm", "", "
        onkeyup=\"changeText(this.form, '$form_sm', '$form_sd', '2');\"
        $sizelen_md $onfocus_s $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    // ���ʳ��ϡ�
    $obj[] =& $form->createElement("text", "s$dd", "", "
        onkeyup=\"changeText(this.form, '$form_sd', '$form_ey', '2');\"
        $sizelen_md $onfocus_s $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", "��");
    // ǯ�ʽ�λ��
    $obj[] =& $form->createElement("text", "e$yy", "", "
        onkeyup=\"changeText(this.form, '$form_ey', '$form_em', '4');\"
        $sizelen_y $onfocus_e $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    // ��ʽ�λ��
    $obj[] =& $form->createElement("text", "e$mm", "", "
        onkeyup=\"changeText(this.form, '$form_em', '$form_ed', '2');\"
        $sizelen_md $onfocus_e $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    // ���ʽ�λ��
    $obj[] =& $form->createElement("text", "e$dd", "", "
        $sizelen_md $onfocus_e $onblur $onkeydown $form_option
    ");

    $gr_obj = $form->addGroup($obj, $form_name, $label, "");  

    return $gr_obj;

}


/**
 * ����     ����POST�ͤ�0���
 *
 * ����     ǯ����������POST�ǡ�����0��ᤷ���֤���null��null���֤���
 *
 * @param   array   $ary_post_date      y, m, d������
 *
 */
function Str_Pad_Date($ary_post_date){

    // ����ξ��
    if (count($ary_post_date) > 0){

        // ����ǥ롼��
        $i = 1;
        foreach ($ary_post_date as $key => $value){
            // ������������
            $pad_len = (bcmod($i, 3) == "1") ? "4" : "2";
            // 0��ᤷ���ѿ����������ͤ�null�ξ���0��᤻����null�򥻥åȡ�
            $ary_pad_date[$key] = ($value != null) ? str_pad($value, $pad_len, "0", STR_PAD_LEFT) : null;
            $i++;
        }

    }

    return $ary_pad_date;

}


/**
 * ����     HTML_QuickForm�����Ѥ��ƶ�ۤ����ϥե������������ϰϡ�
 *
 * ����     ���ϡ���λ�Υե�����̾�����ꤵ��ʤ���硢s, e�Ȥʤ�ޤ�
 *
 * @param object    $form       HTML_QuickForm���֥�������
 * @param string    $form_name  HTML�ǤΥե�����̾
 * @param string    $label      ɽ��̾
 * @param string    $ifs        ���ڤ�ʸ��
 * @param string    $start      ���ϤΥե�����̾
 * @param string    $end        ��λ�Υե�����̾
 *
 */
function Addelement_Money_Range($form, $form_name, $label = "", $ifs = "", $s = "s", $e = "e", $option = ""){

    // global css
    global $g_form_option;

    // °��
    $sizelen    = "size=\"11\" maxLength=\"9\" ";
    $form_option= "class=\"ime_disabled\" class=\"money\" $g_form_option ".$option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$s", "", "$sizelen $form_option");
    $obj[]  =&  $form->createElement("static", "", "", "��");
    $obj[]  =&  $form->createElement("text", "$e", "", "$sizelen $form_option");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * ����     HTML_QuickForm�����Ѥ��Ƽ���襳���ɤ����ϥե�����������6��-4���
 *
 * ����     �����ɣ��������ɣ��Υե�����̾�����ꤵ��ʤ���硢cd1, cd2�Ȥʤ�ޤ�
 *
 * @param object    $form       HTML_QuickForm���֥�������
 * @param string    $form_name  HTML�ǤΥե�����̾
 * @param string    $label      ɽ��̾
 * @param string    $ifs        ���ڤ�ʸ��
 * @param string    $cd1        �����ɣ��Υե�����̾
 * @param string    $cd2        �����ɣ��Υե�����̾
 *
 */
function Addelement_Client_64($form, $form_name, $label = "", $ifs = "", $cd1 = "cd1", $cd2 = "cd2", $option = ""){

    // global css
    global $g_form_option;

    // js�ѥե�����̾
    $form_cd1       = "$form_name"."[".$cd1."]";
    $form_cd2       = "$form_name"."[".$cd2."]";

    // °����js
    $sizelen_cd1    = "size=\"7\" maxLength=\"6\" ";
    $sizelen_cd2    = "size=\"4\" maxLength=\"4\" ";
    $onkeyup_cd1    = "onkeyup=\"changeText(this.form, '$form_cd1', '$form_cd2', 6);\" ";
    $onkeydown      = "onKeyDown=\"chgKeycode();\" ";
    $onfocus        = "onFocus=\"onForm(this);\" ";
    $onblur         = "onBlur=\"blurForm(this);\" ";
    $form_option    = "class=\"ime_disabled\" ".$option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$cd1", "", "$sizelen_cd1 $onkeyup_cd1 $onkeydown $onfocus $onblur $form_option");
    $obj[]  =&  $form->createElement("static", "", "", "$ifs");
    $obj[]  =&  $form->createElement("text", "$cd2", "", "$sizelen_cd2 $onkeydown $onfocus $onblur $form_option");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * ����     HTML_QuickForm�����Ѥ��Ƽ���襳���ɤ����ϥե�����������6��-4�� �����̾��
 *
 * ����     �����ɣ��������ɣ��������̾�Υե�����̾�����ꤵ��ʤ���硢cd1, cd2, name�Ȥʤ�ޤ�
 *
 * @param object    $form       HTML_QuickForm���֥�������
 * @param string    $form_name  HTML�ǤΥե�����̾
 * @param string    $label      ɽ��̾
 * @param string    $ifs        ���ڤ�ʸ��
 * @param string    $cd1        �����ɣ��Υե�����̾
 * @param string    $cd2        �����ɣ��Υե�����̾
 * @param string    $name       �����̾�Υե�����̾
 *
 */
function Addelement_Client_64n($form, $form_name, $label = "", $ifs = "", $cd1 = "cd1", $cd2 = "cd2", $name = "name", $option = ""){

    // global css
    global $g_form_option;

    // js�ѥե�����̾
    $form_cd1       = "$form_name"."[".$cd1."]";
    $form_cd2       = "$form_name"."[".$cd2."]";

    // °����js
    $sizelen_cd1    = "size=\"7\" maxLength=\"6\" ";
    $sizelen_cd2    = "size=\"4\" maxLength=\"4\" ";
    $sizelen_name   = "size=\"34\" maxLength=\"15\" ";
    $onkeyup_cd1    = "onkeyup=\"changeText(this.form, '$form_cd1', '$form_cd2', 6);\" ";
    $onkeydown      = "onKeyDown=\"chgKeycode();\" ";
    $onfocus        = "onFocus=\"onForm(this);\" ";
    $onblur         = "onBlur=\"blurForm(this);\" ";
    $form_option_64 = "class=\"ime_disabled\" ".$option;
    $form_option_n  = $option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$cd1", "", "$sizelen_cd1 $onkeyup_cd1 $onkeydown $onfocus $onblur $form_option_64");
    $obj[]  =&  $form->createElement("static", "", "", "$ifs");
    $obj[]  =&  $form->createElement("text", "$cd2", "", "$sizelen_cd2 $onkeydown $onfocus $onblur $form_option_64");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "$name", "", "$sizelen_name $onkeydown $g_form_option $form_option_n");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * ����     HTML_QuickForm�����Ѥ��Ƽ���襳���ɤ����ϥե�����������6�� �����̾��
 *
 * ����     �����ɣ��������ɣ��������̾�Υե�����̾�����ꤵ��ʤ���硢cd1, cd2, name�Ȥʤ�ޤ�
 *
 * @param object    $form       HTML_QuickForm���֥�������
 * @param string    $form_name  HTML�ǤΥե�����̾
 * @param string    $label      ɽ��̾
 * @param string    $cd1        �����ɣ��Υե�����̾
 * @param string    $name       �����̾�Υե�����̾
 *
 */
function Addelement_Client_6n($form, $form_name, $label = "", $cd1 = "cd1", $name = "name", $option = ""){

    // global css
    global $g_form_option;

    // js�ѥե�����̾
    $form_cd1   = "$form_name"."[".$cd1."]";

    // °����js
    $sizelen_cd1    = "size=\"7\" maxLength=\"6\" ";
    $sizelen_name   = "size=\"34\" maxLength=\"15\" ";
    $onkeydown      = "onKeyDown=\"chgKeycode();\" ";
    $onfocus        = "onFocus=\"onForm(this);\" ";
    $onblur         = "onBlur=\"blurForm(this);\" ";
    $form_option_6  = "class=\"ime_disabled\" ".$option;
    $form_option_n  = $option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$cd1", "", "$sizelen_cd1 $onkeydown $onfocus $onblur $form_option_6");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "$name", "", "$sizelen_name $onkeydown $g_form_option $form_option_n");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * ����     ¿�����������value���Ƥ˻��ꤷ���ؿ���Ŭ��
 *
 * ����     
 *
 * @param   $ary            ����̾
 *          $func           ���Ѥ������ؿ�̾����caseʸ�ɲá�
 *
 * @return  $ary_res        �ؿ�Ŭ�Ѹ������
 */
function Ary_Foreach($ary, $func){

    // $ary�ǥ롼��
    foreach ($ary as $key => $value){

        // ���Ǥ�����ξ��
        if (is_array($value) == true){

            // �Ƶ�Ū�˼�ʬ��Ƥ�
            $ary_res[$key] = Ary_Foreach($value, $func);

        // ���Ǥ�����Ǥʤ����
        }else{

            // $func�˱����ƴؿ�Ŭ��
            switch ($func){
                case "stripslashes" :
                    $ary_res[$key] = stripslashes($value);
                    break;
            }

        }

    }

    // �ؿ�Ŭ�Ѹ��������֤�
    return $ary_res;

}


//������Ψ�����(�ǥե���Ȥϼ��Ҥξ�����Ψ��
function Get_Tax_Rate($db_con,$client_id=NULL){

		if($client_id == NULL){
			$client_id = $_SESSION[client_id];
		}

    //������Ψ����
    $sql  = "SELECT ";
    $sql .= "    tax_rate_n ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    $sql .= "    client_id = $client_id";
    $result = Db_Query($db_con, $sql); 
    $tax = pg_fetch_result($result, 0,0);

    return $tax;

}


/**
 * ���ꤷ�����դξ�����Ψ����
 *
 * ����������������˹�ä����ҥץ��ե�����ξ�����Ψ���֤�
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     0.1.0 (2009/10/21)
 *
 * @param       resource    $db_con     DB�꥽����
 * @param       int         $shop_id    ����å�ID
 * @param       int         $client_id  �����ID
 * @param       string      $date       �׾�����YYYY-MM-DD �����ʤ���ʤ��������������դǽ������ޤ��ˡ�
 *
 * @return      int                     ������Ψ
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2009/10/21                  kajioka-h   ��������
 *
 */
function Get_TaxRate_Day($db_con, $shop_id, $client_id, $date)
{
    //�׾������������ʤ��ξ�硢���������դ�����
    $array = explode("-", $date);
    if(@checkdate($array[1], $array[2], $array[0])){
        $y = $array[0];
        $m = $array[1];
        $d = $array[2];
    }else{
        $y = date("Y");
        $m = date("m");
        $y = date("d");
    }
    $date = date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));

    //�����β��Ƕ�ʬ�����
    $sql  = "SELECT \n";
    $sql .= "    tax_div \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "WHERE \n";
    $sql .= "    client_id = $client_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $tax_div = pg_fetch_result($result, 0, 0);

    //���Ƕ�ʬ3������ǡˤμ����Ͼ�����Ψ0
    if($tax_div == "3"){
        return 0;
    }

    //���Ҥξ�������������
    $sql  = "SELECT \n";
    $sql .= "    tax_rate_old, \n";
    $sql .= "    tax_rate_now, \n";
    $sql .= "    tax_change_day_now, \n";
    $sql .= "    tax_rate_new, \n";
    $sql .= "    tax_change_day_new \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "WHERE \n";
    $sql .= "    client_id = $shop_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);

    $tax_rate_old       = pg_fetch_result($result, 0, 0);	//�������Ψ
    $tax_rate_now       = pg_fetch_result($result, 0, 1);	//��������Ψ
    $tax_change_day_now = pg_fetch_result($result, 0, 2);	//����Ψ������
    $tax_rate_new       = pg_fetch_result($result, 0, 3);	//��������Ψ
    $tax_change_day_new = pg_fetch_result($result, 0, 4);	//����Ψ������

    //����Ψ����������������դϵ������Ψ
    if($date < $tax_change_day_now){
        return (int)$tax_rate_old;

    //��������Ψ�����������Ǥʤ�����������Ψ�ʸ�����դϿ�������Ψ
    }elseif($tax_change_day_new != NULL && $date >= $tax_change_day_new){
        return (int)$tax_rate_new;
    }

    //�嵭�ʳ��ϸ�������Ψ
    return (int)$tax_rate_now;

}


//ü����ʬ�����
function Get_Tax_div($db_con,$client_id){

    //������ξ�������
    $sql  = "SELECT";
    $sql .= "    coax, ";
    $sql .= "    tax_franct ";
    $sql .= "FROM";
    $sql .= "    t_client ";
    $sql .= "WHERE";
    $sql .= "    client_id = $client_id;";
    $result = Db_Query($db_con, $sql);
    $tax_div = pg_fetch_array($result);

    return $tax_div;

}


/**
 * ����     �������ּ����ؿ�
 *
 * ����     ���ꤵ�줿�����ID�ξ��֤�����������ֽ�����HTML���֤�
 *
 * @param   $db_con             DB�꥽����
 *          $client_id  int     �����ID
 *
 * @return  str                 ���֡�html��
 */
function Get_Client_State($db_con, $client_id){

    // �����ID��������
    if ($client_id != null){

        // ���ּ���
        $sql  = "SELECT \n";
        $sql .= "   state \n";
        $sql .= "FROM \n";
        $sql .= "   t_client \n";
        $sql .= "WHERE \n";
        $sql .= "   client_id = $client_id \n";
        $sql .= ";"; 
        $res  = Db_Query($db_con, $sql);
        $client_state = pg_fetch_result($res, 0, 0);

        // ���ϥǡ�������
        switch ($client_state){
            case "1":
                $client_state_print = "<span style=\"color: #555555;\">�����</span>\n";
                break;  
            case "2":
                $client_state_print = "<span style=\"color: #ff0000; font-weight: bold;\">���󡦵ٻ���</span>\n";
                break;  
            default:
                $client_state_print = null; 
        }

        // ���Ϥ����̤��֤�
        return $client_state_print;

    // �����ID���ʤ����
    }else{

        return null;

    }

}


/**
 * ����     FC��������ʬ��FC�������̾�Υҥ����쥯�����������
 *
 * ����     
 *
 * @param   $db_con             DB�꥽����
 *
 * @return  array               FC��������ʬ��FC�������̾�Υҥ����쥯��������
 */
function Make_Ary_Shop($db_con, $where = null){

    $sql  = "SELECT \n";
    $sql .= "   t_rank.rank_cd, \n";
    $sql .= "   t_rank.rank_name, \n";
    $sql .= "   t_client.client_id, \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2, \n";
    $sql .= "   t_client.client_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   INNER JOIN t_rank ON  t_rank.rank_cd = t_client.rank_cd \n";
    $sql .= "                     AND t_rank.disp_flg = 't' \n";
    $sql .= $where." \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_rank.rank_cd, \n";
    $sql .= "   t_rank.rank_name, \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2 \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // hierselect���������
    $ary_hier1[null] = null; 
    $ary_hier2       = null; 

    // �ǡ�����������
    if ($num > 0){

        for ($i=0; $i<$num; $i++){

            // �ǡ��������ʥ쥳�������
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);

            // ʬ����䤹���褦�˳Ƴ��ؤ�ID���ѿ�������
            $hier1_id = $data_list[$i]["rank_cd"];
            $hier2_id = $data_list[$i]["client_id"];

            /* ��1��������������� */
            // ���߻��ȥ쥳���ɤ�FC��������ʬ�����ɤ����˻��Ȥ����쥳���ɤ�FC��������ʬ�����ɤ��ۤʤ���
            if ($data_list[$i]["rank_cd"] != $data_list[$i-1]["rank_cd"]){
                // ��1���ؼ��������ƥ�������
                $ary_hier1[$hier1_id] = $data_list[$i]["rank_cd"]." �� ".htmlentities($data_list[$i]["rank_name"], ENT_COMPAT, EUC);
            }

            /* ��2��������������� */
            // ���߻��ȥ쥳���ɤ�FC��������ʬ�����ɤ����˻��Ȥ����쥳���ɤ�FC��������ʬ�����ɤ��ۤʤ���
            // �ޤ��ϡ����߻��ȥ쥳���ɤ�FC�������ID�����˻��Ȥ����쥳���ɤ�FC�������ID���ۤʤ���
            if (
                $data_list[$i]["rank_cd"] != $data_list[$i-1]["rank_cd"] ||
                $data_list[$i]["client_id"] != $data_list[$i-1]["client_id"]
            ){
                // ��2���ؼ��������ƥ�������
                $ary_hier2[$hier1_id][$hier2_id]  = $data_list[$i]["client_cd1"];
                $ary_hier2[$hier1_id][$hier2_id] .= ($data_list[$i]["client_cd2"] != null) ? "-".$data_list[$i]["client_cd2"] : null;
                $ary_hier2[$hier1_id][$hier2_id] .= " �� ";
                $ary_hier2[$hier1_id][$hier2_id] .= htmlentities($data_list[$i]["client_cname"], ENT_COMPAT, EUC);
            }

        }

        // 1�Ĥ�����ˤޤȤ��֤�
        return array($ary_hier1, $ary_hier2);

    // 1���̵�����
    }else{

        // ����������֤�
        $array[null] = null;
        return array($array, $array);

    }

}


/**
 * ����     HTML_QuickForm�����Ѥ�����ɼ�ֹ�����ϥե������������ϰϡ�
 *
 * ����     ���ϡ���λ�Υե�����̾�����ꤵ��ʤ���硢s, e�Ȥʤ�ޤ�
 *
 * @param object    $form       HTML_QuickForm���֥�������
 * @param string    $form_name  HTML�ǤΥե�����̾
 * @param string    $label      ɽ��̾
 * @param string    $ifs        ���ڤ�ʸ��
 * @param string    $start      ���ϤΥե�����̾
 * @param string    $end        ��λ�Υե�����̾
 *
 */
function Addelement_Slip_Range($form, $form_name, $label = "", $ifs = "", $s = "s", $e = "e", $option = ""){

    // global css
    global $g_form_option;

    // °��
    $sizelen    = "size=\"10\" maxLength=\"8\" ";
    $form_option= "class=\"ime_disabled\" $g_form_option ".$option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$s", "", "$sizelen $form_option");
    $obj[]  =&  $form->createElement("static", "", "", "��");
    $obj[]  =&  $form->createElement("text", "$e", "", "$sizelen $form_option");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * ����     ����������껦�ʹߥ����å�
 *
 * ����     ���դ�����������껦���ʹߤ�������å�����
 *
 * @param resource  $db_con     DB��³�꥽����
 * @param int       $client_id  ������ID
 * @param sring     $claim_div  �������ʬ
 * @param string    $y          �����å��������ա�ǯ��
 * @param string    $m          �����å��������աʷ��
 * @param string    $d          �����å��������ա�����
 *
 */
function Check_Adv_Offset_Day($db_con, $client_id, $claim_div, $y, $m, $d){

    // ����������껦�������
    $sql  = "SELECT \n";
    //$sql .= "   COALESCE(MAX(t_payin_h.pay_day), '".START_DAY."') \n";
    $sql .= "   MAX(t_payin_h.pay_day) \n";
    $sql .= "FROM \n";
    $sql .= "   t_payin_h \n";
    $sql .= "   INNER JOIN t_payin_d \n";
    $sql .= "       ON  t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       AND t_payin_d.trade_id = 40 \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payin_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payin_h.claim_div = '$claim_div' \n";
    $sql .= ";"; 

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num == 0){
        return true;
    }

    $last_day = pg_fetch_result($res, 0, 0);

    // �������Ϥ��줿���դ�0���/���
    $arg_day  = Str_Pad_Date(array($y, $m, $d));
    $post_day = $arg_day[0]."-".$arg_day[1]."-".$arg_day[2];

    // ���Ϥ��줿���� <= ��Ф������ա����顼
    if ($post_day <= $last_day){
        return false;
    }
    return true;

}


/**
 * ����     ���򤵤줿������������褬¸�ߤ��뤫�����å�
 *
 * ����     
 *
 * @param resource  $db_con     DB��³�꥽����
 * @param int       $client_id  ������ID
 * @param sring     $claim_div  �������ʬ
 *
 */
function Check_Claim_Alive($db_con, $client_id, $claim_div){

    // �����褬¸�ߤ��뤫�����å�
    $sql .= "SELECT \n";
    $sql .= "   COUNT(*) \n";
    $sql .= "FROM \n";
    $sql .= "   t_claim \n";
    $sql .= "INNER JOIN t_client ON  t_claim.claim_id = t_client.client_id \n";
    $sql .= "                    AND t_claim.client_id = $client_id \n";
    $sql .= "                    AND t_claim.claim_div = '$claim_div' \n";
    $sql .= "                    AND t_client.shop_id IN ".Rank_Sql2()." \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $cnt  = pg_fetch_result($res, 0, 0);

    // 0��ʤ饨�顼
    if ($cnt == 0){
        return false;
    }
    return true;

}


/**
 * ����     �إå����ܥ�������ؿ�
 *
 * ����     
 *
 * @param           $form       �ե�����
 * @param ary       $ary_list   �ܥ���value => ����� ������
 * @param int       $color_no   �ܥ���˿����դ����ֹ�ʻ����̵�����ϼ�ư�ǡ�
 *
 */
function Make_H_Link_Btn($form, $ary_list, $color_no = null){

    global $g_button_color;

    $i = 1;

    foreach ($ary_list as $key => $value){

        // �ܥ��󿧥��ץ����
        if ($color_no != null){
            $color_opt = ($i == $color_no) ? $g_button_color : null;
        }else{
            $value = str_replace("../", "", $value);    // ���Хѥ��ξ�̳��ػ������
            $value = str_replace("./",  "", $value);    // ���Хѥ��Υ����Ȼ������
            $color_opt = (strpos($_SERVER["PHP_SELF"], $value) !== false) ? $g_button_color : null;
        }

        // �ܥ���̾����
        $start_num = (strrpos($value, "/") === false) ? 0 : strrpos($value, "/") + 1;
        $str_cnt   = strrpos($value, ".") - $start_num;
        $btn_name  = substr($value, $start_num, $str_cnt)."_link_button";

        // �ܥ������
        $form->addELement("button", $btn_name, $key, $color_opt." onClick=\"location.href='$value'\"");

        $i++;

    }

}


/**
 * ����     �إå����ܥ�����ϴؿ�
 *
 * ����     
 *
 * @param           $form       �ե�����
 * @param ary       $ary_list   �ܥ���value => ���URL ������
 *
 */
function Print_H_Link_Btn($form, $ary_list){

    foreach ($ary_list as $key => $value){

        // �ܥ���̾����
        $start_num = (strrpos($value, "/") === false) ? 0 : strrpos($value, "/") + 1;
        $str_cnt   = strrpos($value, ".") - $start_num;
        $btn_name  = substr($value, $start_num, $str_cnt)."_link_button";

        // �ܥ������
        $print    .= "��".$form->_elements[$form->_elementIndex[$btn_name]]->toHtml();

    }

    return $print;

}


/**
 * ����     �����ʥ�С��ե����ޥå�
 *
 * ����     �����ʸ���б����������б���null��null�б�
 *
 * @param int       $int        ����
 * @param int       $dot        �����貿�̤ޤ�ɽ�����뤫��Ǥ�ա�
 * @param boolean   $null       true: ����null�ʤ�null�Τޤ��֤���Ǥ�ա�
 *
 */
function Numformat_Ortho($int, $dot = 0, $null = null){

    if ($null === true && $int === null){
        return null;
    }else{
        return ($int < 0) ? "<span style=\"color: #ff0000;\">".number_format($int, $dot)."</span>" : number_format($int, $dot);
    }

}


/**
 * ����     ��������Ф���������Ĺ���������
 *
 * ����     ��������Ф���������Ĺ��������������̤������ߡ�
 *
 * @param resource  $db_con     DB��³�꥽����
 * @param string    $count_day  ������
 * @param int       $client_id  ������ID
 * @param boolean   $claim_div  �������ʬ
 * @param int       $sale_id    ��������ȯ�����������껦�ۤϴޤޤʤ���
 *
 */
function Advance_Offset_Claim($db_con, $count_day, $client_id, $claim_div, $sale_id=null){

    $sql  = "SELECT \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) < 0 THEN 0 \n";
    $sql .= "       ELSE COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) \n";
    $sql .= "   END \n";
    $sql .= "   AS advances_balance \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id, \n";
    $sql .= "           SUM(amount) AS advance_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           claim_div = '$claim_div' \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data ON t_client.client_id = advance_data.client_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.client_id, \n";
    $sql .= "           SUM(t_payin_d.amount) AS payin_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           claim_div = '$claim_div' \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = ".$_SESSION["client_id"]." \n";
    if($sale_id != null){
        $sql .= "       AND \n";
        $sql .= "           t_payin_h.sale_id != $sale_id \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS payin_data ON t_client.client_id = payin_data.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '1' \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num == 0){
        $advance_offset = 0;
    }else{
        $advance_offset = pg_fetch_result($res, 0, 0);
    }

    return $advance_offset;
    

}


/**
 * ����     ��������Ф���������Ĺ���������
 *
 * ����     ��������Ф���������Ĺ��������������̤������ߡ�
 *
 * @param resource  $db_con     DB��³�꥽����
 * @param string    $count_day  ������
 * @param int       $client_id  ������ID
 * @param boolean   $motocho    true�ʤ������껦��ɼ�⽸���������Τ�Τǽ��פ����ե饰�������踵Ģ�ǻȤäƤ���
 *
 */
function Advance_Offset_Client($db_con, $count_day, $client_id, $motocho = null){

    $sql  = "SELECT \n";
    $sql .= "   COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) AS advances_balance \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id, \n";
    $sql .= "           SUM(amount) AS advance_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data ON t_client.client_id = advance_data.client_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.client_id, \n";
    $sql .= "           SUM(t_payin_d.amount) AS payin_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    if ($motocho === true){
        $sql .= "       AND \n";
        $sql .= "           t_payin_h.pay_day <= '$count_day' \n";
    }
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS payin_data ON t_client.client_id = payin_data.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '1' \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num == 0){
        $advance_offset = 0;
    }else{
        $advance_offset = pg_fetch_result($res, 0, 0);
    }

    return $advance_offset;
    

}


/**
 * ����     ���ꤵ�줿�������ˡ���������Ф�����ꤵ��Ƥ��ʤ���������ɼ���ʤ��������å�
 *
 * ����     ���ꤵ�줿�������ˡ���������Ф�����ꤵ��Ƥ��ʤ���������ɼ���ʤ��������å�����
 *
 * @param resource  $db_con     DB��³�꥽����
 * @param string    $count_day  ������
 * @param int       $client_id  ������ID
 * @param boolean   $claim_div  �������ʬ
 *
 */
function Chk_Advance_Fix($db_con, $count_day, $client_id, $claim_div){

    // �������ǡ����ꤵ��Ƥ��ʤ���ɼ�����
    $sql  = "SELECT \n";
    $sql .= "   advance_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "WHERE \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   claim_div = '$claim_div' \n";
    $sql .= "AND \n";
    $sql .= "   pay_day <= '$count_day' \n";
    $sql .= "AND \n";
    $sql .= "   fix_day IS NULL \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // ���ꤵ��Ƥ��ʤ���ɼ��������ϥ��顼���ʤ�����true
    return ($num > 0) ?  false : true;

}


/**
 * ����     ���դ������������ʹߤ��ɤ���������å�
 *
 * ����     ���դ������������ʹߤ��ɤ���������å�
 *
 * @param   resource    $db_con     DB��³�꥽����
 * @param   int         $client_id  ������ID 
 * @param   string      $y          �����å��������դ�ǯ
 * @param   string      $m          �����å��������դη�
 * @param   string      $d          �����å��������դ���
 *
 */
function Check_Bill_Close_Day_Claim($db_con, $client_id, $claim_div, $y, $m, $d){

    $sql  = "SELECT \n";
    //$sql .= "   COALESCE(MAX(bill_close_day_this), '".START_DAY."') \n";
    $sql .= "   MAX(bill_close_day_this) \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill_d \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill_d.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_bill_d.claim_div = '$claim_div' \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num == 0){
        return true;
    }

    $bill_close_day = pg_fetch_result($res, 0, 0);

    // �������Ϥ��줿���դ���
    $y = str_pad($y, 4, 0, STR_PAD_LEFT);
    $m = str_pad($m, 2, 0, STR_PAD_LEFT);
    $d = str_pad($d, 2, 0, STR_PAD_LEFT);
    $pram_date = $y."-".$m."-".$d;

    // ��Ф������դ��Ϥ��줿���դ���礭�����ϥ��顼
    if($bill_close_day >= $pram_date){
        return false;
    }
    return true;

}


/**
 * ����     �Ȳ�����ѥ����ȥ�󥯺���
 *
 * ����     
 *
 * @param               $form           �ե�����
 * @param   array       $ary_sort_link  �������륽���ȥ��ã������ǵ��Ҥ�����Ρ�"�ե�����̾" => "���ɽ��̾"��
 * @param   string      $def_item       ������֤Υ������оݥե�����̾
 * @param   string      $hdn_form       ���򤵤줿�����ƥ�򥻥åȤ���hidden��Ǥ�ա�
 *
 */
function Addelement_Sort_Link($form, $ary_sort_link, $def_item, $hdn_form = null){

    if ($hdn_form === null){
        $hdn_form = "hdn_sort_col";
    }

    // �����ȥ�󥯺���
    foreach ($ary_sort_link as $f_name => $value){

        // ���򤬤ʤ����ʽ��ɽ�����ˡܺ��������󥯤��ǥե���ȥ����ƥ�ξ��
        // ������֤ǰ������Ϥ���Ƥ��������
        if ($_POST[$hdn_form] == null && $f_name == $def_item){
            $form->addElement("static", $f_name, null, $value."��");
        }

        // ���򤵤줿��
        elseif ($_POST[$hdn_form] == $f_name){
            $form->addElement("static", $f_name, null, $value);
        }

        // ���򤵤�Ƥ��ʤ���
        else{
            $form->addElement("link", $f_name, "", $_SERVER["PHP_SELF"], $value, 
                "onClick=\"javascript:Button_Submit('$hdn_form', '".$_SERVER["PHP_SELF"]."', '".$f_name."'); return false;\""
            );
        }
    }

    // ���������Ƴ�Ǽ��hidden����
    $form->addElement("hidden", $hdn_form);

    // ����hidden�ˡ����ꤵ�줿����ͤ򥻥å�
    $set_def[$hdn_form] = $def_item;
    $form->setDefaults($set_def);

}


/**
 * ����     �Ȳ�����ѥ����ȥ�󥯽��ϡ�.php�ѡ�
 *
 * ����     
 *
 * @param               $form       �ե�����
 * @param   string      $f_name     �ե�����̾
 *
 */
function Make_Sort_Link($form, $f_name){

    return $form->_elements[$form->_elementIndex[$f_name]]->toHtml().Make_Sort_Mark($f_name);

}


/**
 * ����     �Ȳ�����ѥ����ȥ�󥯽��ϡ�.tpl�ѡ�
 *
 * ����     .php¦�Ǥ��δؿ���쥸���Ȥ���.tpl¦�ǥ����뤷�Ƥ��������ʰ���: form=$form f_name="�����ȥ�󥯥ե�����̾"��
 *
 * @param   array       $params     �ƥ�ץ졼�Ȥ���ƥ�ץ졼�ȴؿ����Ϥ��줿���Ƥ�°���ϡ�Ϣ������Ȥ���$params�˳�Ǽ����ޤ�
 *
 */
function Make_Sort_Link_Tpl($params){

    if ($params["hdn_form"] === null){
        return $params["form"][$params["f_name"]]["html"].Make_Sort_Mark($params["f_name"]);
    }else{
        return $params["form"][$params["f_name"]]["html"].Make_Sort_Mark($params["f_name"], $params["hdn_form"]);
    }

}


/**
 * ����     �Ȳ�����ѥ����ȥ�󥯤ξ��ֽ���
 *
 * ����     ���Make_Sort_Link, Make_Sort_Link_Tpl�˥����뤵��ޤ�
 *
 * @param   string      $f_name     �ե�����̾
 * @param   string      $hdn_form   ���򤵤줿�����ƥब���åȤ��Ƥ���hidden��Ǥ�ա�
 *
 */
function Make_Sort_Mark($f_name, $hdn_form = null){

    if ($hdn_form === null){
        $hdn_form = "hdn_sort_col";
    }

    return ($_POST[$hdn_form] == $f_name) ? "��" : null;

}


/**
 * ����     ������οƻҴط�������å�����
 *
 * ����     
 *
 * @param   resource  $db_con       DB��³�꥽����
 * @param   int       $claim_id     ������ID
 *
 */
function Claim_Filiation_Chk($db_con, $target_claim_id){

    // ���оݤ�������ID�פ�������Ȥ�����Ͽ���Ƥ�������������
    $sql  = "SELECT \n";
    $sql .= "   client_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_claim \n";
    $sql .= "WHERE \n";
    $sql .= "   claim_id = $target_claim_id \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // ���оݤ�������ID�פ�������Ȥ�����Ͽ���Ƥ��������褬ʣ��������ϿƻҴط�����
    $filiation_flg = ($num > 1) ? true : null;

    // ���оݤ�������ID�פ�������Ȥ�����Ͽ���Ƥ��������褬1��ξ��
    if ($num == 1){

        /*      
        �����ˤ���ѥ�����
            ����ʬ�����������Ͽ���Ƥ�����Ω
        */

        $filiation_flg = null;

    }

    // �ƻҴط����ꡧtrue
    // �ƻҴط��ʤ���null
    return $filiation_flg;

}


/**
 * ����     ������οƻҴط�������å�����
 *
 * ����     
 *
 * @param   resource  $db_con       DB��³�꥽����
 * @param   int       $client_id    ������ID
 *
 */
function Client_Filiation_Chk($db_con, $client_id){

    // ���ꤵ�줿�����������������
    $sql  = "SELECT \n";
    $sql .= "   claim_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_claim \n";
    $sql .= "WHERE \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // �����褬2�濫����ϿƻҴط�����
    $filiation_flg = ($num > 1) ? true : null;

    // �����褬1��ξ��
    if ($num == 1){

        /*      
        �����ˤ���ѥ�����
            ���ƤοƤΤߤ����������Ͽ���Ƥ����
            ����        �����������Ͽ���Ƥ����
            ����ʬ      �����������Ͽ���Ƥ����
            ����ʬ      �����������Ͽ���Ƥ�����Ω
        */

        // �оݤ�������ID�����
        $target_claim_id = pg_fetch_result($res, 0, 0);

        // ������ID�ȡ��оݤ�������ID���㤦���ϿƻҴط�����ʿƤ����������Ͽ���Ƥ���ҡ�
        $filiation_flg = ($client_id != $target_claim_id) ? true : null;

        // ������ID�ȡ��оݤ�������ID��Ʊ�����
        if ($client_id == $target_claim_id){

            /*      
            �����ˤ���ѥ�����
                ����ʬ�����������Ͽ���Ƥ����
                ����ʬ�����������Ͽ���Ƥ�����Ω
            */

            // ���оݤ�������ID�פοƻҴط�������å�����
            $filiation_flg = Claim_Filiation_Chk($db_con, $target_claim_id);

        }

    }

    // �ƻҴط����ꡧtrue
    // �ƻҴط��ʤ���null
    return $filiation_flg;

}

?>