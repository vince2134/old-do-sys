<?php
$page_title = "��ݻĹ���Ͽ���ѹ��ڡ���";
require_once("ENV_local.php");
$db_con = Db_Connect();
$form =& new HTML_QuickForm("dateForm","POST","$_SERVER[PHP_SELF]");
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/**************************/
//�ե��������
/**************************/
$form->addElement("text","form_shop_id","","style='$g_form_style' maxlength=6 size=6 $g_form_option");
$form->addElement("text","form_client_id","","style='$g_form_style' maxlength=6 size=6 $g_form_option");
$date[] =& $form->createElement("text","year","","size=4 maxlength=4 style='$g_form_style' $g_form_option");
$date[] =& $form->createElement("static","","","-");
$date[] =& $form->createElement("text","month","","size=2 maxlength=2 style='$g_form_style' $g_form_option");
$date[] =& $form->createElement("static","","","-");
$date[] =& $form->createElement("text","day","","size=2 maxlength=2 style='$g_form_style' $g_form_option");
$form->addGroup($date,"form_monthly_close_day_this","form_monthly_close_day_this");
$form->addElement("text","form_ap_balance","","style='$g_form_style' maxlength=20 size=20 $g_form_option");
$form->addElement("submit","update_btn","�Ρ�ǧ");
$form->addElement("button","reset","�ꥻ�å�","onclick=\"javascript:location.href('$_SERVER[PHP_SELF]')\" ");
$form->addElement("hidden","check_flg",null);
$form->addElement("hidden","day_flg",null);

//print_array($_POST);
//�ܥ��󲡲�
if($_POST['update_btn'] != "" || $_POST['exe_btn'] != ""){
    Db_Query($db_con,"BEGIN;");
    //POST�����
    $year = $_POST['form_monthly_close_day_this']['year'];      //ǯ
    $month = $_POST['form_monthly_close_day_this']['month'];    //��
    $day = $_POST['form_monthly_close_day_this']['day'];        //��
    $client_id = $_POST['form_client_id'];                      //���饤�����ID
    $shop_id = $_POST['form_shop_id'];                          //����å�ID
    $input_flg = true;                                  //�����ͥ����å��ե饰
    $check_flg = $_POST['check_flg'];                   //�����å��ե饰
    $ap_balance = $_POST['form_ap_balance'];                 //��ݻĹ�
    //�����ͥ����å�
    //���դ����Ϥ���Ƥ��뤫
    if($year == "" && $month == "" && $day == ""){
        $day_flg = null;
    //���������դ�
    }elseif(checkdate($month,$day,$year)){
        $day_flg = true;
        $monthly_close_day_this = $year."-".$month."-".$day;
    //�������ʤ�
    }else{
        $day_flg = false;
    }

    //���饤�����ID�����Ϥ���Ƥ��뤫
    if($client_id == ""){
        $input_flg = false;
    }

    //��ݻĹ⤬���Ϥ��줤�ơ����ͤ��ɤ���
    if($ap_balance =="" && is_numeric($ap_balance) != true){
        $input_flg = false;
    }
    //��Υ����å���OK�ʤ�
    if($input_flg && ($day_flg == null||$day_flg == true)){
        //��ʧͽ�꤬���뤫�ɤ��������å�
        $sql  = "SELECT ";
        $sql .= "  * ";
        $sql .= "FROM ";
        $sql .= "  t_schedule_payment ";
        $sql .= "WHERE ";
        $sql .= " client_id = $client_id ";
        $sql .= ";";

        $res = Db_Query($db_con,$sql);
        $cnt = pg_num_rows($res);

        $sql  = "SELECT ";
        $sql .= "   * ";
        $sql .= "FROM ";
        $sql .= "   t_buy_h ";
        $sql .= "WHERE ";
        $sql .= "   client_id = $client_id ";
        $sql .= ";";
        $res = Db_Query($db_con,$sql);
        $cnt2 = pg_num_rows($res);
        //��ʧͽ�꤬������ϡ��ѹ�����Ͽ�Ȥ�ˤ��ʤ���
        if($cnt > 0 || $cnt2 > 0){
            $err_msg =  "��ʧ�ѤߤǤ���";
        }else{
            //��ݻĹ�ơ��֥�˥ǡ��������뤫�����å�
            $search_sql  = "SELECT ";
            $search_sql .= "    * ";
            $search_sql .= "FROM ";
            $search_sql .= "   t_first_ap_balance ";
            $search_sql .= "WHERE ";
            $search_sql .= "   client_id = $client_id ";
            $search_sql .= ";";

            $search_sql2  = "SELECT ";
            $search_sql2 .= "   * ";
            $search_sql2 .= "FROM ";
            $search_sql2 .= "   t_ap_balance ";
            $search_sql2 .= "WHERE ";
            $search_sql2 .= "   client_id = $client_id";
            $search_sql2 .= ";";

            $res = Db_Query($db_con,$search_sql);
            $cnt = pg_num_rows($res);
            $res = Db_Query($db_con,$search_sql2);
            $cnt2 = pg_num_rows($res);

            if($cnt > 0 && $cnt2 > 0){
            //�ǡ���������й���
            //�ѹ����ǡ�������
                $befor = pg_fetch_array($res,0);
                $bef = $befor['ap_balance_this'];
                $btn_push = "��ݻĹ���ѹ����ޤ���".number_format($bef)." �� ".number_format($ap_balance);
                $form->addElement("submit","exe_btn","������");
                $set_data['check_flg'] = true;
                $set_data['day_flg'] = $day_flg;
                $form->setConstants($set_data);
            }else{
            //�ǡ������ʤ���п�����Ͽ����
                $btn_push = "��ݻĹ�򿷵���Ͽ���ޤ���";
                $form->addElement("submit","exe_btn","������");
                $set_data['check_flg']=true;
                $set_data['day_flg'] = $day_flg;
                $form->setConstants($set_data);
            }
            //�����ܥ������
            if($_POST['exe_btn'] == "������" && $_POST['check_flg']==true){
                //����ơ��֥�
                $sql_f  = "UPDATE ";
                $sql_f .= "   t_first_ap_balance ";
                $sql_f .= "SET ";
                $sql_f .= "   ap_balance = $ap_balance ";
                $sql_f .= "WHERE ";
                $sql_f .= "   client_id = $client_id ";
                $sql_f .= ";";
                //��ơ��֥�
                $sql_ap  = "UPDATE ";
                $sql_ap .= "    t_ap_balance ";
                $sql_ap .= "SET ";
                $sql_ap .= "    ap_balance_this = $ap_balance ";
                if($day_flg == true){
                    $sql_ap .= "    ,monthly_close_day_this = '$monthly_close_day_this' ";
                }
                $sql_ap .= "WHERE ";
                $sql_ap .= "    client_id = $client_id ";
                $sql_ap .= ";";
                $res = Db_Query($db_con,$sql_f);
                if($res === false){
                    Db_Query($db_con,"ROLLBACK;");
                    print "���顼��".$sql_f;
                    exit;
                }
                $res = Db_Query($db_con,$sql_ap);
                        if($res === false){
                    Db_Query($db_con,"ROLLBACK;");
                    print "���顼��".$sql_ap;
                    exit;
                }
                $ap_fin_msg =  "��ݽ������ΣգУģ��ԣŴ�λ��";
                $exit_flg = true;
            //�����ܥ��󲡲������ա�����å�ID�����Ϥ���Ƥ��뤫��ǧ��
            }elseif($_POST['exe_btn']=="������" && $_POST['check_flg']==true && $day_flg==true&& $shop_id != "" ){
                //����ơ��֥���ɲ�
                $sql  = "INSERT INTO t_first_ap_balance (";
                $sql .= "   ap_balance,";
                $sql .= "   client_id,";
                $sql .= "   shop_id";
                $sql .= ") VALUES (";
                $sql .= "   $ap_balance,";
                $sql .= "   $client_id,";
                $sql .= "   $shop_id";
                $sql .= ");";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
                //������ξ�������
                $sql  = "
                    SELECT
                        t_client.close_day,
                        t_client.pay_m,
                        t_client.pay_d,
                        t_client.client_cd1,
                        t_client.client_cd2,
                        t_client.client_name AS client_name1,
                        t_client.client_name2,
                        t_client.client_cname,
                        t_staff1.staff_name AS staff1_name,
                        t_staff2.staff_name AS staff2_name,
                        t_client.c_tax_div,
                        t_client.tax_franct,
                        t_client.coax,
                        t_client.tax_div
                    FROM
                        t_client
                        LEFT JOIN t_staff AS t_staff1 ON t_client.sv_staff_id = t_staff1.staff_id
                        LEFT JOIN t_staff AS t_staff2 ON t_client.b_staff_id1 = t_staff2.staff_id
                    WHERE
                        t_client.client_id = $client_id
                    ;
                ";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
                $client_data = pg_fetch_array($result);

                foreach ($client_data as $key => $value){
                    $client_data[$key] = addslashes($value);
                }
                //��ơ��֥���ɲ�
                $sql  = "
                    INSERT INTO
                        t_ap_balance
                    (
                        ap_balance_id,
                        monthly_close_day_last,
                        monthly_close_day_this,
                        close_day,
                        payout_m,
                        payout_d,
                        client_id,
                        client_cd1,
                        client_cd2,
                        client_name1,
                        client_name2,
                        client_cname,
                        ap_balance_last,
                        pay_amount,
                        tune_amount,
                        rest_amount,
                        net_buy_amount,
                        tax_amount,
                        intax_buy_amount,
                        ap_balance_this,
                        staff1_name,
                        amortization_trade_balance,
                        amortization_amount,
                        shop_id,
                        tax_rate_n,
                        c_tax_div,
                        tax_franct,
                        coax,
                        tax_div
                    ) VALUES (
                        (SELECT COALESCE(MAX(ap_balance_id), 0)+1 FROM t_ap_balance),
                        '".START_DAY."',
                        '$monthly_close_day_this',
                        '".$client_data["close_day"]."',
                        '".$client_data["pay_m"]."',
                        '".$client_data["pay_d"]."',
                        $client_id,
                        '".$client_data["client_cd1"]."',
                        '".$client_data["client_cd2"]."',
                        '".$client_data["client_name1"]."',
                        '".$client_data["client_name2"]."',
                        '".$client_data["client_cname"]."',
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        $ap_balance,
                        '".$client_data["staff1_name"]."',
                        0,
                        0,
                        $shop_id,
                        (SELECT tax_rate_n FROM t_client WHERE client_id = $shop_id),
                        '".$client_data["c_tax_div"]."',
                        '".$client_data["tax_franct"]."',
                        '".$client_data["coax"]."',
                        '".$client_data["tax_div"]."'
                    );
                ";
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }
                $ap_fin_msg =  "��ݻĹ�������ΣɣΣӣţңԴ�λ��";
                $exit_flg = true;
            //������Ͽ�ξ������դȥ���å�ID���ǧ
            }elseif($_POST['exe_btn'] == "������" && ($day_flg != true || $shop_id == "") ){
                $err_msg =  "��Ͽ�ξ��ϡ�����å�ID�����դ����������Ϥ��Ƥ�������";
            }
        }
    }else{
        $err_msg = "�����Ϥ��Ƥ���������";
    }
//��������λ�����������ͤ򥯥ꥢ����
if($exit_flg == true){
    $set_data['form_shop_id'] = "";
    $set_data['form_client_id'] = "";
    $set_data['form_monthly_close_day_this']['year'] = "";
    $set_data['form_monthly_close_day_this']['month'] = "";
    $set_data['form_monthly_close_day_this']['day'] = "";
    $set_data['form_ap_balance'] = "";
    $set_data['check_flg'] = "";
    $form->setConstants($set_data);
}
Db_Query($db_con,"COMMIT;");
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
$page_menu = Create_Menu_h('buy','3');

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
        'html_header'               => "$html_header",
    'html'                      => "$html",
    'exit_flg'          => "$exit_flg",
    'btn_push'          => "$btn_push",
    'err_msg'           => "$err_msg",
    'ap_fin_msg'        => "$ap_fin_msg",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
));
$smarty->assign('ary_data',$ary);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


?>
