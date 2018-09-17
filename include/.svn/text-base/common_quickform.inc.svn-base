<?php

/****************************
Tips

・表示させないフォームはモジュール側でremoveElementしてください
    $form->removeElement("フォーム名");
・第3引数を追加（watanabe-k）
    初期値配列を渡せるようにしました。

****************************/

/****************************/
// 共通フォームパーツ定義（売上）
/****************************/
function Search_Form($db_con, $form, $def_fdata = null, $output_type = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"      => "1",         // 表示件数
            "form_output_type"      => "1",         // 出力形式
            "form_round_day[sy]"    => date("Y"),   // 予定巡回日（当月1日）
            "form_round_day[sm]"    => date("m"),
            "form_round_day[sd]"    => "01",
            "form_round_day[ey]"    => date("Y"),   // 予定巡回日（当月末日）
            "form_round_day[em]"    => date("m"),
            "form_round_day[ed]"    => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    if ($output_type === true){
        // 出力形式
        $obj    =   null;   
        $obj[]  =&  $form->createElement("radio", null, null, "画面", "1");
        $obj[]  =&  $form->createElement("radio", null, null, "CSV",  "2");
        $form->addGroup($obj, "form_output_type", "", " ");
    }

    // 顧客担当支店
    $item   =   null;   
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_client_branch", "", $item, $g_form_option_select);

    // 所属本支店
    $item   =   null;
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_attach_branch", "", $item, $g_form_option_select);

    // 得意先
    Addelement_Client_64n($form, "form_client", "得意先", "-");

    // 巡回担当者
    $obj    =   null;
    $item   =   null;
    $item   =   Select_Get($db_con, "round_staff_m");
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_round_staff", "", "");

    // 部署
    $item   =   null;
    $item   =   Select_Get($db_con, "part");
    $form->addElement("select", "form_part", "", $item, $g_form_option_select);

    // 請求先
    Addelement_Client_64n($form, "form_claim", "請求先", "-");

    // 巡回担当者（複数選択）
    $form->addElement("text", "form_multi_staff",  "", "size=\"40\" class=\"ime_disabled\" $g_form_option");

    // 倉庫
    $item   =   null;
    $item   =   Select_Get($db_con, "ware", "WHERE shop_id = ".$_SESSION["client_id"]." AND staff_ware_flg = 'f' AND nondisp_flg = 'f' ");
    $form->addElement("select", "form_ware", "", $item, $g_form_option_select);

    // 予定巡回日（開始〜終了）
    Addelement_Date_Range($form, "form_round_day", "予定巡回日", "-");
    
    // 請求日（開始〜終了）
    Addelement_Date_Range($form, "form_claim_day", "請求日", "-");

    // 取引先区分付きバージョン
    // 委託先FC
    $item   =   null;
    $item   =   Make_Ary_shop($db_con);
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd1",  "", "size=\"7\" maxLength=\"6\" class=\"ime_disabled\"
                onkeyup=\"changeText(this.form,'form_charge_fc[cd1]','form_charge_fc[cd2]',6);\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "-");
    $obj[]  =&  $form->createElement("text", "cd2",  "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "<br>");
    $obj[]  =&  $form->createElement("hierselect", "select", "", "$g_form_option_select", " ");
    $obj[6]->setOptions($item);
    $form->addGroup($obj, "form_charge_fc", "", "");

/*
    // 取引先区分なしバージョン
    // 委託先FC
    $obj    =   null;
    $item   =   null;
    $item   =   Select_Get($db_con, "fshop");
    $obj[]  =&  $form->createElement("text", "cd1",  "", "size=\"7\" maxLength=\"6\" class=\"ime_disabled\"
                onkeyup=\"changeText(this.form,'form_charge_fc[cd1]','form_charge_fc[cd2]',6);\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "-");
    $obj[]  =&  $form->createElement("text", "cd2",  "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "<br>");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_charge_fc", "", "");
*/

    return $form;

}


/****************************/
// 共通フォームパーツ定義（本部売上）
/****************************/
function Search_Form_Sale_H($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"      => "1",         // 表示件数
            "form_sale_day[sy]"     => date("Y"),   // 売上計上日（当月1日）
            "form_sale_day[sm]"     => date("m"),
            "form_sale_day[sd]"     => "01",
            "form_sale_day[ey]"     => date("Y"),   // 売上計上日（当月末日）
            "form_sale_day[em]"     => date("m"),
            "form_sale_day[ed]"     => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 出力形式
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "画面", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "帳票", "2");
    $obj[]  =&  $form->createElement("radio", null, null, "CSV",  "3");
    $form->addGroup($obj, "form_output_type", "", " ");

    // FC・取引先
    Addelement_Client_64n($form, "form_client", "得意先", "-");

    // 売上担当者
    $obj    =   null;
    $item   =   null;
    $item   =   Select_Get($db_con, "staff", null, true);
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_sale_staff", "", "");

    // 倉庫
    $item   =   null;
    $item   =   Select_Get($db_con, "ware");
    $form->addElement("select", "form_ware", "", $item, $g_form_option_select);

    // 請求先
    Addelement_Client_64n($form, "form_claim", "請求先", "-");

    // 売上担当複数選択
    $form->addElement("text", "form_multi_staff",  "", "size=\"40\" class=\"ime_disabled\" $g_form_option");

    // 売上計上日（開始〜終了）
    Addelement_Date_Range($form, "form_sale_day", "予定巡回日", "-");
    
    // 請求日（開始〜終了）
    Addelement_Date_Range($form, "form_claim_day", "請求日", "-");

    return $form;

}


/****************************/
// 共通フォームパーツ定義（入金）
/****************************/
function Search_Form_Payin($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"      => "1",         // 表示件数
            "form_payin_day[sy]"    => date("Y"),   // 入金日
            "form_payin_day[sm]"    => date("m"),
            "form_payin_day[sd]"    => "01",
            "form_payin_day[ey]"    => date("Y"),   // 入金日（当月末日）
            "form_payin_day[em]"    => date("m"),
            "form_payin_day[ed]"    => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 顧客担当支店
    $item   =   null;   
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_client_branch", "", $item, $g_form_option_select);

    // 所属本支店
    $item   =   null;
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_attach_branch", "", $item, $g_form_option_select);

    // 得意先
    Addelement_Client_64n($form, "form_client", "得意先", "-");

    // 集金担当者
    $sql  = "SELECT \n";
    $sql .= "   t_attach.staff_id, \n";
    $sql .= "   t_staff.charge_cd, \n";
    $sql .= "   t_staff.staff_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "   INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "WHERE \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   t_attach.shop_id IN (".Rank_Sql().") \n";
    }else{
    $sql .= "   t_attach.shop_id = ".$_SESSION["client_id"]." \n";
    }
    $sql .= "AND \n";
    $sql .= "   t_staff.state != '退職' \n";
    $sql .= "ORDER BY \n";
    $sql .= "   charge_cd \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $item       = null;
    $item[""]   = "";
    while($data_list = pg_fetch_array($res)){
        $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
        $data_list[2] = htmlspecialchars($data_list[2]);
        $item[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
    }
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_collect_staff", "", "");

    // 部署
    $item   =   null;
    $item   =   Select_Get($db_con, "part");
    $form->addElement("select", "form_part", "", $item, $g_form_option_select);

    // 取引区分
    $item   =   null;
    $item   =   Select_Get($db_con, "trade_payin");
    $form->addElement("select", "form_trade", "", $item, $g_form_option_select);

    // 集金担当複数選択
    $form->addElement("text", "form_multi_staff",  "", "size=\"40\" class=\"ime_disabled\" $g_form_option");

    // 入金日（開始〜終了）
    Addelement_Date_Range($form, "form_payin_day", "入金日", "-");

    // 入力日（開始〜終了）
    Addelement_Date_Range($form, "form_input_day", "入力日", "-");

    // 取引先区分付きバージョン
    // 代行店
    $item   =   null;
    $item   =   Make_Ary_shop($db_con);
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd1",  "", "size=\"7\" maxLength=\"6\" class=\"ime_disabled\"
                onkeyup=\"changeText(this.form,'form_act_client[cd1]','form_act_client[cd2]',6);\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "-");
    $obj[]  =&  $form->createElement("text", "cd2",  "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "<br>");
    $obj[]  =&  $form->createElement("hierselect", "select", "", "", " ");
    $obj[6]->setOptions($item);
    $form->addGroup($obj, "form_act_client", "", "");

/*
    // 取引先区分なしバージョン
    // 代行店
    $item   =   null;
    $sql  = "SELECT \n";
    $sql .= "   t_client.client_id, \n";
    $sql .= "   t_client.client_cd1,\n";
    $sql .= "   t_client.client_cd2,\n";
    $sql .= "   t_client.client_cname\n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.client_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   t_rank.group_kind = '3' \n";
    $sql .= "AND \n";
    $sql .= "   t_client.state = '1' \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2 \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $item       = null;
    $item[""]   = "";
    while($data_list = pg_fetch_array($res)){
        $data_list[3] = htmlspecialchars($data_list[3]);
        $item[$data_list[0]] = $data_list[1]."-".$data_list[2]." ： ".$data_list[3];
    }
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd1",  "", "size=\"7\" maxLength=\"6\" class=\"ime_disabled\"
                onkeyup=\"changeText(this.form,'form_act_client[cd1]','form_act_client[cd2]',6);\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "-");
    $obj[]  =&  $form->createElement("text", "cd2",  "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "<br>");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_act_client", "", "");
*/

    return $form;

}


/****************************/
// 共通フォームパーツ定義（本部入金）
/****************************/
function Search_Form_Payin_H($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"      => "1",         // 表示件数
            "form_payin_day[sy]"    => date("Y"),   // 入金日
            "form_payin_day[sm]"    => date("m"),
            "form_payin_day[sd]"    => "01",
            "form_payin_day[ey]"    => date("Y"),   // 入金日（当月末日）
            "form_payin_day[em]"    => date("m"),
            "form_payin_day[ed]"    => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // FC・取引先
    Addelement_Client_64n($form, "form_client", "得意先", "-");

    // 取引区分
    $item   =   null;
    $item   =   Select_Get($db_con, "trade_payin");
    unset($item[40]);
    $form->addElement("select", "form_trade", "", $item, $g_form_option_select);

    // 入金日（開始〜終了）
    Addelement_Date_Range($form, "form_payin_day", "入金日", "-");

    // 入力日（開始〜終了）
    Addelement_Date_Range($form, "form_input_day", "入力日", "-");

    return $form;

}


/****************************/
// 共通フォームパーツ定義（受注）
/****************************/
function Search_Form_Aord($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"      => "1",         // 表示件数
            "form_aord_day[sy]"     => date("Y"),   // 受注日（当月1日）
            "form_aord_day[sm]"     => date("m"),
            "form_aord_day[sd]"     => "01",
            "form_aord_day[ey]"     => date("Y"),   // 受注日（当月末日）
            "form_aord_day[em]"     => date("m"),
            "form_aord_day[ed]"     => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // FC・取引先
    Addelement_Client_64n($form, "form_client", "FC・取引先", "-");

    // 受注担当者
    $obj    =   null;
    $item   =   null;
    $item   =   Select_Get($db_con, "staff", null, true);
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_c_staff", "", "");

    // 倉庫
    $item   =   null;
    $item   =   Select_Get($db_con, "ware");
    $form->addElement("select", "form_ware", "", $item, $g_form_option_select);

    // 請求先
    Addelement_Client_64n($form, "form_claim", "請求先", "-");

    // 受注担当複数選択
    $form->addElement("text", "form_multi_staff",  "", "size=\"40\" class=\"ime_disabled\" $g_form_option");

    // 受注日（開始〜終了）
    Addelement_Date_Range($form, "form_aord_day", "受注日", "-");
    
    // 出荷予定日（開始〜終了）
    Addelement_Date_Range($form, "form_arrival_day", "出荷予定日", "-");

    // 直送先
    $form->addElement("text", "form_direct", "", "size=\"34\" maxLength=\"15\" $g_form_option");

    return $form;

}


/****************************/
// 共通フォームパーツ定義（仕入）
/****************************/
function Search_Form_Buy($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"  => "1",         // 表示件数
            "form_buy_day[sy]"  => date("Y"),   // 仕入日
            "form_buy_day[sm]"  => date("m"),
            "form_buy_day[sd]"  => "01",
            "form_buy_day[ey]"  => date("Y"),   // 仕入日（当月末日）
            "form_buy_day[em]"  => date("m"),
            "form_buy_day[ed]"  => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 出力形式
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "画面", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "帳票", "2");
    $obj[]  =&  $form->createElement("radio", null, null, "CSV",  "3");
    $form->addGroup($obj, "form_output_type", "", " ");

    // 顧客担当支店
    $item   =   null;   
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_client_branch", "", $item, $g_form_option_select);

    // 所属本支店
    $item   =   null;
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_attach_branch", "", $item, $g_form_option_select);

    // 仕入先
    Addelement_Client_64n($form, "form_client", "仕入先", "-");

    // 仕入担当者
    $item   =   null;
    if ($_SESSION["group_kind"] == "1"){
        $item   =   Select_Get($db_con, "staff", "true");
    }else{
        $item   =   Select_Get($db_con, "staff", null, true);
    }
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_c_staff", "", "");

    // 部署
    $item   =   null;
    $item   =   Select_Get($db_con, "part");
    $form->addElement("select", "form_part", "", $item, $g_form_option_select);

    // 仕入日
    Addelement_Date_Range($form, "form_buy_day", "仕入日", "-");

    // 取引区分
    $item   =   null;
    $item   =   Select_Get($db_con, "trade_buy");
    $form->addElement("select", "form_trade", "", $item, $g_form_option_select);

    // 仕入担当者（複数選択）
    $form->addElement("text", "form_multi_staff",  "", "size=\"40\" class=\"ime_disabled\" $g_form_option");

    // 倉庫
    $item   =   null;
    $item   =   Select_Get($db_con, "ware", "WHERE shop_id = ".$_SESSION["client_id"]." AND staff_ware_flg = 'f' AND nondisp_flg = 'f' ");
    $form->addElement("select", "form_ware", "", $item, $g_form_option_select);

    return $form;

}


/****************************/
// 共通フォームパーツ定義（本部仕入）
/****************************/
function Search_Form_Buy_H($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"  => "1",         // 表示件数
            "form_buy_day[sy]"  => date("Y"),   // 仕入日
            "form_buy_day[sm]"  => date("m"),
            "form_buy_day[sd]"  => "01",
            "form_buy_day[ey]"  => date("Y"),   // 仕入日（当月末日）
            "form_buy_day[em]"  => date("m"),
            "form_buy_day[ed]"  => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 出力形式
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "画面", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "帳票", "2");
    $obj[]  =&  $form->createElement("radio", null, null, "CSV",  "3");
    $form->addGroup($obj, "form_output_type", "", " ");

    // 仕入先
    Addelement_Client_64n($form, "form_client", "仕入先", "-");

    // 仕入担当者
    $item   =   null;
    if ($_SESSION["group_kind"] == "1"){
        $item   =   Select_Get($db_con, "staff", "true");
    }else{
        $item   =   Select_Get($db_con, "staff", null, true);
    }
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_c_staff", "", "");

    // 倉庫
    $item   =   null;
    $item   =   Select_Get($db_con, "ware", "WHERE shop_id = ".$_SESSION["client_id"]." AND nondisp_flg = 'f' ");
    $form->addElement("select", "form_ware", "", $item, $g_form_option_select);

    // 仕入日
    Addelement_Date_Range($form, "form_buy_day", "仕入日", "-");

    // 仕入担当複数選択
    $form->addElement("text", "form_multi_staff",  "", "size=\"40\" class=\"ime_disabled\" $g_form_option");

    return $form;

}


/****************************/
// 共通フォームパーツ定義（支払）
/****************************/
function Search_Form_Payout($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"  => "1",         // 表示件数
            "form_pay_day[sy]"  => date("Y"),   // 支払日
            "form_pay_day[sm]"  => date("m"),
            "form_pay_day[sd]"  => "01",
            "form_pay_day[ey]"  => date("Y"),   // 支払日（当月末日）
            "form_pay_day[em]"  => date("m"),
            "form_pay_day[ed]"  => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 顧客担当支店
    $item   =   null;   
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_client_branch", "", $item, $g_form_option_select);

    // 仕入先
    Addelement_Client_64n($form, "form_client", "仕入先", "-");

    // 支払番号（開始〜終了）
    Addelement_Slip_Range($form, "form_pay_no", "支払番号");

    // 支払日（開始〜終了）
    Addelement_Date_Range($form, "form_pay_day", "支払日", "-");

    // 合計金額（開始〜終了）
    Addelement_Money_Range($form, "form_sum_amount", "合計金額", "");

    // 入力日（開始〜終了）
    Addelement_Date_Range($form, "form_input_day", "入力日", "-");

    // 決済日（開始〜終了）
    Addelement_Date_Range($form, "form_account_day", "決済日", "-");

    return $form;

}


/****************************/
// 共通フォームパーツ定義（本部支払）
/****************************/
function Search_Form_Payout_H($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"  => "1",         // 表示件数
            "form_pay_day[sy]"  => date("Y"),   // 支払日
            "form_pay_day[sm]"  => date("m"),
            "form_pay_day[sd]"  => "01",
            "form_pay_day[ey]"  => date("Y"),   // 支払日（当月末日）
            "form_pay_day[em]"  => date("m"),
            "form_pay_day[ed]"  => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 仕入先
    Addelement_Client_64n($form, "form_client", "仕入先", "-");

    // 支払番号（開始〜終了）
    Addelement_Slip_Range($form, "form_pay_no", "支払番号");

    // 支払日（開始〜終了）
    Addelement_Date_Range($form, "form_pay_day", "支払日", "-");

    // 合計金額（開始〜終了）
    Addelement_Money_Range($form, "form_sum_amount", "合計金額", "");

    // 入力日（開始〜終了）
    Addelement_Date_Range($form, "form_input_day", "入力日", "-");

    // 決済日（開始〜終了）
    Addelement_Date_Range($form, "form_account_day", "決済日", "-");

    return $form;

}


/****************************/
// 共通フォームパーツ定義（発注）
/****************************/
function Search_Form_Ord($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"  => "1",         // 表示件数
            "form_ord_day[sy]"  => date("Y"),   // 発注日
            "form_ord_day[sm]"  => date("m"),
            "form_ord_day[sd]"  => "01",
            "form_ord_day[ey]"  => date("Y"),   // 発注日（当月末日）
            "form_ord_day[em]"  => date("m"),
            "form_ord_day[ed]"  => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 顧客担当支店
    $item   =   null;   
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_client_branch", "", $item, $g_form_option_select);

    // 所属本支店
    $item   =   null;
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_attach_branch", "", $item, $g_form_option_select);

    // 発注先
    Addelement_Client_6n($form, "form_client", "発注先");

    // 発注担当者
    $item   =   Select_Get($db_con, "staff", null, true);
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_c_staff", "", "");

    // 部署
    $item   =   null;
    $item   =   Select_Get($db_con, "part");
    $form->addElement("select", "form_part", "", $item, $g_form_option_select);

    // 発注日
    Addelement_Date_Range($form, "form_ord_day", "発注日", "-");

    // 発注番号（開始〜終了）
    Addelement_Slip_Range($form, "form_ord_no", "発注番号");

    // 発注担当者（複数選択）
    $form->addElement("text", "form_multi_staff",  "", "size=\"40\" class=\"ime_disabled\" $g_form_option");

    // 倉庫
    $item   =   null;
    $item   =   Select_Get($db_con, "ware", "WHERE shop_id = ".$_SESSION["client_id"]." AND staff_ware_flg = 'f' AND nondisp_flg = 'f' ");
    $form->addElement("select", "form_ware", "", $item, $g_form_option_select);

    // 希望納期
    Addelement_Date_Range($form, "form_hope_day", "希望納期", "-");

    // 直送先
    $form->addElement("text", "form_direct", "", "size=\"34\" maxLength=\"15\" $g_form_option");

    return $form;

}


/****************************/
// 共通フォームパーツ定義（本部発注）
/****************************/
function Search_Form_Ord_H($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"  => "1",         // 表示件数
            "form_ord_day[sy]"  => date("Y"),   // 発注日
            "form_ord_day[sm]"  => date("m"),
            "form_ord_day[sd]"  => "01",
            "form_ord_day[ey]"  => date("Y"),   // 発注日（当月末日）
            "form_ord_day[em]"  => date("m"),
            "form_ord_day[ed]"  => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 発注先
    Addelement_Client_64n($form, "form_client", "発注先", "-");

    // 発注担当者
    $item   =   Select_Get($db_con, "staff", "", true);
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_c_staff", "", "");

    // 倉庫
    $item   =   null;
    $item   =   Select_Get($db_con, "ware", "WHERE shop_id = ".$_SESSION["client_id"]." AND nondisp_flg = 'f' ");
    $form->addElement("select", "form_ware", "", $item, $g_form_option_select);

    // 発注日
    Addelement_Date_Range($form, "form_ord_day", "発注日", "-");

    // 発注担当者（複数選択）
    $form->addElement("text", "form_multi_staff",  "", "size=\"40\" class=\"ime_disabled\" $g_form_option");

    // 発注番号（開始〜終了）
    Addelement_Slip_Range($form, "form_ord_no", "発注番号");

    // 入荷予定日
    //Addelement_Date_Range($form, "form_arrival_day", "入荷予定日", "-");

    // 希望納期
    Addelement_Date_Range($form, "form_hope_day", "希望納期", "-");

    // 直送先
    $form->addElement("text", "form_direct", "", "size=\"34\" maxLength=\"15\" $g_form_option");

    return $form;

}


/****************************/
// 共通フォームパーツ定義（請求）
/****************************/
function Search_Form_Claim($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"      => "1",         // 表示件数
            "form_close_day[y]"     => date("Y"),   // 請求締日
            "form_close_day[m]"     => date("m"),
            "form_close_day[d]"     => "0",
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 出力形式
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "画面", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "帳票", "2");
    $form->addGroup($obj, "form_output_type", "", " ");

    // 顧客担当支店
    $item   =   null;   
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_client_branch", "", $item, $g_form_option_select);

    // 所属本支店
    $item   =   null;
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_attach_branch", "", $item, $g_form_option_select);

    // 得意先
    Addelement_Client_64n($form, "form_client", "得意先", "-");

    // 巡回担当者
    $item   =   Select_Get($db_con, "cstaff");
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_round_staff", "", "");

    // 部署
    $item   =   null;
    $item   =   Select_Get($db_con, "part");
    $form->addElement("select", "form_part", "", $item, $g_form_option_select);

    // 請求先
    Addelement_Client_64n($form, "form_claim", "請求先", "-");

    // 請求額（開始〜終了）
    Addelement_Money_Range($form, "form_amount_this", "請求額");

    // 請求締日
    $sql  = "SELECT \n";
    $sql .= "   DISTINCT close_day \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   client_div = '1' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    for ($i = 0; $i < $num; $i++){
        $client_close_day[] = pg_fetch_result($res, $i, 0);
    }
    if ($num > 0){
        asort($client_close_day);
        $client_close_day = array_values($client_close_day);
    }
    $item   =   null;
    $item[0]=   "全て";
    for ($i = 0; $i < $num; $i++){
        if ($client_close_day[$i] < 29 && $client_close_day[$i] != ""){
            $item[(int)$client_close_day[$i]] = (int)$client_close_day[$i]."日";
        }else
        if ($client_close_day[$i] != "" && $client_close_day[$i] >= 29){
            $item[(int)$client_close_day[$i]] = "月末";
        }
    }
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
        onkeyup=\"changeText(this.form, 'form_close_day[y]', 'form_close_day[m]', 4);\" 
        onFocus=\"onForm_today2(this, this.form, 'form_close_day[y]', 'form_close_day[m]');\"
        onBlur=\"blurForm(this);\"
    ");
    $obj[]  =&  $form->createElement("text", "m", "", "size=\"1\" maxLength=\"2\" class=\"ime_disabled\"
        onkeyup=\"changeText(this.form, 'form_close_day[m]', 'form_close_day[d]', 4);\" 
        onFocus=\"onForm_today2(this, this.form, 'form_close_day[y]', 'form_close_day[m]');\"
        onBlur=\"blurForm(this);\"
    ");
    $obj[]  =&  $form->createElement("select", "d", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_close_day", "請求締日", "-");

    // 回収予定日
    Addelement_Date_Range($form, "form_collect_day", "回収予定日", "-");
    
    // 委託先FC
    $item   =   null;
    $item   =   Make_Ary_shop($db_con);
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd1",  "", "size=\"7\" maxLength=\"6\" class=\"ime_disabled\"
                onkeyup=\"changeText(this.form,'form_charge_fc[cd1]','form_charge_fc[cd2]',6);\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "-");
    $obj[]  =&  $form->createElement("text", "cd2",  "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\"
                $g_form_option
                ");
    $obj[]  =&  $form->createElement("static", "", "", "<br>");
    $obj[]  =&  $form->createElement("hierselect", "select", "", "$g_form_option_select", " ");
    $obj[6]->setOptions($item);
    $form->addGroup($obj, "form_charge_fc", "", "");

    return $form;

}


/****************************/
// 共通フォームパーツ定義（本部請求）
/****************************/
function Search_Form_Claim_H($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"      => "1",         // 表示件数
            "form_close_day[y]"     => date("Y"),   // 請求締日
            "form_close_day[m]"     => date("m"),
            "form_close_day[d]"     => "0",
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 出力形式
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "画面", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "帳票", "2");
    $form->addGroup($obj, "form_output_type", "", " ");

    // FC・取引先
    Addelement_Client_64n($form, "form_client", "FC・取引先", "-");

    // 担当者（SV）
    $item   =   Select_Get($db_con, "staff");
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_sv_staff", "", "");

    // 請求先
    Addelement_Client_64n($form, "form_claim", "請求先", "-");

    // 請求額（開始〜終了）
    Addelement_Money_Range($form, "form_amount_this", "請求額");

    // 請求締日
    $sql  = "SELECT \n";
    $sql .= "   DISTINCT close_day \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   client_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    for ($i = 0; $i < $num; $i++){
        $client_close_day[] = pg_fetch_result($res, $i, 0);
    }
    if ($num > 0){
        asort($client_close_day);
        $client_close_day = array_values($client_close_day);
    }
    $item   =   null;
    $item[0]=   "全て";
    for ($i = 0; $i < $num; $i++){
        if ($client_close_day[$i] < 29 && $client_close_day[$i] != ""){
            $item[(int)$client_close_day[$i]] = (int)$client_close_day[$i]."日";
        }else
        if ($client_close_day[$i] != "" && $client_close_day[$i] >= 29){
            $item[(int)$client_close_day[$i]] = "月末";
        }
    }
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
        onkeyup=\"changeText(this.form, 'form_close_day[y]', 'form_close_day[m]', 4);\" 
        onFocus=\"onForm_today2(this, this.form, 'form_close_day[y]', 'form_close_day[m]');\"
        onBlur=\"blurForm(this);\"
    ");
    $obj[]  =&  $form->createElement("text", "m", "", "size=\"1\" maxLength=\"2\" class=\"ime_disabled\"
        onkeyup=\"changeText(this.form, 'form_close_day[m]', 'form_close_day[d]', 4);\" 
        onFocus=\"onForm_today2(this, this.form, 'form_close_day[y]', 'form_close_day[m]');\"
        onBlur=\"blurForm(this);\"
    ");
    $obj[]  =&  $form->createElement("select", "d", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_close_day", "請求締日", "-");

    // 回収予定日
    Addelement_Date_Range($form, "form_collect_day", "回収予定日", "-");
    
    return $form;

}


/****************************/
// 共通フォームパーツ定義（前受金）
/****************************/
function Search_Form_Advance($db_con, $form, $def_fdata = null){


    /****************************/
    // 初期値設定
    /****************************/
    //引数が無い場合
    if($def_fdata == null){
        $def_fdata = array(
            "form_display_num"      => "1",         // 表示件数
            "form_pay_day[sy]"      => date("Y"),   // 入金日
            "form_pay_day[sm]"      => date("m"),
            "form_pay_day[sd]"      => "01",
            "form_pay_day[ey]"      => date("Y"),   // 入金日（当月末日）
            "form_pay_day[em]"      => date("m"),
            "form_pay_day[ed]"      => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
        );
    }
    $form->setDefaults($def_fdata);


    /****************************/
    // フォームパーツ定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 表示件数
    $obj    =   null;   
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
    $form->addGroup($obj, "form_display_num", "", " ");

    // 顧客担当支店
    $item   =   null;   
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_client_branch", "", $item, $g_form_option_select);

    // 所属本支店
    $item   =   null;
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_attach_branch", "", $item, $g_form_option_select);

    // 得意先
    Addelement_Client_64n($form, "form_client", "得意先", "-");

    // 担当者
    $item   =   Select_Get($db_con, "round_staff_m");
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("select", "select", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_staff", "", "");

    // 部署
    $item   =   null;
    $item   =   Select_Get($db_con, "part");
    $form->addElement("select", "form_part", "", $item, $g_form_option_select);

    // 入金日（開始〜終了）
    Addelement_Date_Range($form, "form_pay_day", "入金日", "-");

    // 伝票番号（開始〜終了）
    Addelement_Slip_Range($form, "form_advance_no", "伝票番号");

    // 入力日（開始〜終了）
    Addelement_Date_Range($form, "form_input_day", "入力日", "-");

    // 金額（開始〜終了）
    Addelement_Money_Range($form, "form_amount", "金額");

    // 銀行
    $obj    =   null;   
    $obj[]  =   $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\" $g_form_option");
    $form->addGroup($obj, "form_bank", "", "");

    // 支店
    $obj    =   null;   
    $obj[]  =   $form->createElement("text", "cd", "", "size=\"3\" maxLength=\"3\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\" $g_form_option");
    $form->addGroup($obj, "form_b_bank", "", "");

    // 口座番号
    $form->addElement("text", "form_account_no", "", "size=\"8\" maxLength=\"7\" class=\"ime_disabled\" $g_form_option");

    // 預金種目
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "全て", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "普通", "2");
    $obj[]  =&  $form->createElement("radio", null, null, "当座", "3");
    $form->addGroup($obj, "form_deposit_kind", "", " ");

    // 前受金確定
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "全て",   "1");
    $obj[]  =&  $form->createElement("radio", null, null, "未確定", "2");
    $obj[]  =&  $form->createElement("radio", null, null, "確定済", "3");
    $form->addGroup($obj, "form_fix", "", " ");
    
    return $form;

}


/****************************/
// 共通検索テーブルHTML（売上）
/****************************/
function Search_Table($form, $output_type = null){

    if ($output_type === true){

        // フォームリスト
        $ary_list = array(
            "display_num",
            "output_type",
            "client_branch",
            "attach_branch",
            "client",
            "round_staff",
            "part",
            "claim",
            "multi_staff",
            "ware",
            "round_day",
            "claim_day",
            "charge_fc",
        );

    }else{

        // フォームリスト
        $ary_list = array(
            "display_num",
            "client_branch",
            "attach_branch",
            "client",
            "round_staff",
            "part",
            "claim",
            "multi_staff",
            "ware",
            "round_day",
            "claim_day",
            "charge_fc",
        );

    }

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null || $ary_to_html["claim"] != null || ($ary_to_html["charge_fc"] != null && $_SESSION["group_kind"] == "2")){
        $form_name      = null;
        $disp_form_name = null;
        if ($ary_to_html["client"] != null){
            $form_name[] = "「得意先」";
        }
        if ($ary_to_html["claim"] != null){
            $form_name[] = "「請求先」";
        }
        if ($ary_to_html["charge_fc"] != null && $_SESSION["group_kind"] == "2"){
            $form_name[] = "「委託先FC」";
        }
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value;
        }
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
//    $html_s .= "<table width=\"100%\">\n";    //一覧のテーブルのほうが大きい場合表示が崩れるため、1000pxに固定（watanabe-k）
    $html_s .= "<table width=\"1000px\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    if ($ary_to_html["output_type"] != null){
    $html_s .= "        <td>\n";
    }else{
    $html_s .= "        <td colspan=\"2\">\n";
    }
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b>".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    if ($ary_to_html["output_type"] != null){
    $html_s .= "        <td align=\"right\">\n";
    $html_s .= "            <b>出力形式</b> ".$ary_to_html["output_type"]."<br>\n";
    $html_s .= "        </td>\n";
    }
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["client_branch"] != null){
    $html_s .= "            <b>顧客担当支店</b> ".$ary_to_html["client_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["attach_branch"] != null){
    $html_s .= "            <b>所属本支店</b> ".$ary_to_html["attach_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1000px\">\n";
    $html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"250px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">得意先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["round_staff"]."\">巡回担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["round_staff"]."\">".$ary_to_html["round_staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">部署</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">".$ary_to_html["part"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">請求先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">".$ary_to_html["claim"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\">巡回担当者<br>（複数選択）<br></td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\">\n";
    $html_s .= "            ".$ary_to_html["multi_staff"].(($ary_to_html["multi_staff"] != null) ? "<br>例）0001,0002\n" : "\n");
    $html_s .= "        </td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">倉庫</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">".$ary_to_html["ware"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["round_day"]."\">予定巡回日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["round_day"]."\">".$ary_to_html["round_day"]."</td>\n";
    if ($_SESSION["group_kind"] == "2"){
    $html_s .= "        <td class=\"".$ary_td["charge_fc"]."\" rowspan=\"2\">委託先FC</td>\n";
    $html_s .= "        <td class=\"".$ary_td["charge_fc"]."\" rowspan=\"2\" colspan=\"3\">".$ary_to_html["charge_fc"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["claim_day"]."\">請求日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["claim_day"]."\">".$ary_to_html["claim_day"]."</td>\n";
    }else{
    $html_s .= "        <td class=\"".$ary_td["claim_day"]."\">請求日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["claim_day"]."\" colspan=\"3\">".$ary_to_html["claim_day"]."</td>\n";
    }
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（本部売上）
/****************************/
function Search_Table_Sale_H($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "output_type",
        "client",
        "sale_staff",
        "ware",
        "claim",
        "multi_staff",
        "sale_day",
        "claim_day",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null || $ary_to_html["claim"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「FC・取引先」";
        }       
        if ($ary_to_html["claim"] != null){
            $form_name[] = "「請求先」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["output_type"] != null){
    $html_s .= "            <b>出力形式</b> ".$ary_to_html["output_type"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1030px\">\n";
    $html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"250px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">FC・取引先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["sale_staff"]."\">売上担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["sale_staff"]."\">".$ary_to_html["sale_staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">倉庫</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">".$ary_to_html["ware"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">請求先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">".$ary_to_html["claim"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\">売上担当複数選択</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\" colspan=\"3\">\n";
    $html_s .= "            ".$ary_to_html["multi_staff"].(($ary_to_html["multi_staff"] != null) ? " 例）0001,0002\n" : "\n");
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["sale_day"]."\">売上計上日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["sale_day"]."\">".$ary_to_html["sale_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["claim_day"]."\">請求日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["claim_day"]."\" colspan=\"3\">".$ary_to_html["claim_day"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（入金）
/****************************/
function Search_Table_Payin($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "client_branch",
        "attach_branch",
        "client",
        "collect_staff",
        "part",
        "trade",
        "multi_staff",
        "payin_day",
        "input_day",
        "act_client",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null || ($ary_to_html["act_client"] != null && $_SESSION["group_kind"] == "2")){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「得意先」";
        }       
        if ($ary_to_html["act_client"] != null && $_SESSION["group_kind"] == "2"){
            $form_name[] = "「代行店」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td colspan=\"2\">\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b>".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name\n";
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["client_branch"] != null){
    $html_s .= "            <b>顧客担当支店</b> ".$ary_to_html["client_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["attach_branch"] != null){
    $html_s .= "            <b>所属本支店</b> ".$ary_to_html["attach_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1000px\">\n";
    $html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"250px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">得意先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["collect_staff"]."\">集金担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["collect_staff"]."\">".$ary_to_html["collect_staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">部署</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">".$ary_to_html["part"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["trade"]."\">取引区分</td>\n";
    $html_s .= "        <td class=\"".$ary_td["trade"]."\">".$ary_to_html["trade"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\">集金担当複数選択</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\" colspan=\"3\">\n";
    $html_s .= "            ".$ary_to_html["multi_staff"].(($ary_to_html["multi_staff"] != null) ? " 例）0001,0002\n" : "\n");
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["payin_day"]."\">入金日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["payin_day"]."\">".$ary_to_html["payin_day"]."</td>\n";
    if ($_SESSION["group_kind"] == "2"){
    $html_s .= "        <td class=\"".$ary_td["act_client"]."\" rowspan=\"2\">代行店</td>\n";
    $html_s .= "        <td class=\"".$ary_td["act_client"]."\" rowspan=\"2\" colspan=\"3\">".$ary_to_html["act_client"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">入力日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">".$ary_to_html["input_day"]."</td>\n";
    }else{
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">入力日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\" colspan=\"3\">".$ary_to_html["input_day"]."</td>\n";
    }
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（本部入金）
/****************************/
function Search_Table_Payin_H($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "client",
        "trade",
        "payin_day",
        "input_day",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「FC・取引先」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td colspan=\"2\">\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"793px\">\n";
    $html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">FC・取引先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["trade"]."\">取引区分</td>\n";
    $html_s .= "        <td class=\"".$ary_td["trade"]."\">".$ary_to_html["trade"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["payin_day"]."\">入金日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["payin_day"]."\">".$ary_to_html["payin_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">入力日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">".$ary_to_html["input_day"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（受注）
/****************************/
function Search_Table_Aord($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "client",
        "c_staff",
        "ware",
        "claim",
        "multi_staff",
        "aord_day",
        "arrival_day",
        "direct"
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null || $ary_to_html["claim"] != null || $ary_to_html["direct"]){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「FC・取引先」";
        }       
        if ($ary_to_html["claim"] != null){
            $form_name[] = "「請求先」";
        }       
        if ($ary_to_html["direct"] != null){
            $form_name[] = "「直送先」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td colspan=\"2\">\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1050px\">\n";
    $html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"250px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">FC・取引先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">受注担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">".$ary_to_html["c_staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">倉庫</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">".$ary_to_html["ware"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">請求先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">".$ary_to_html["claim"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\">受注担当複数選択</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\" colspan=\"3\">\n";
    $html_s .= "            ".$ary_to_html["multi_staff"].(($ary_to_html["multi_staff"] != null) ? " 例）0001,0002\n" : "\n");
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "        <td class=\"".$ary_td["aord_day"]."\">受注日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["aord_day"]."\">".$ary_to_html["aord_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["arrival_day"]."\">出荷予定日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["arrival_day"]."\" colspan=\"3\">".$ary_to_html["arrival_day"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "        <td class=\"".$ary_td["direct"]."\">直送先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["direct"]."\" colspan=\"5\">".$ary_to_html["direct"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（仕入）
/****************************/
function Search_Table_Buy($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "output_type",
        "client_branch",
        "attach_branch",
        "client",
        "c_staff",
        "part",
        "buy_day",
        "trade",
        "multi_staff",
        "ware",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「仕入先」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td colspan=\"2\">\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["output_type"] != null){
    $html_s .= "            <b>出力形式</b> ".$ary_to_html["output_type"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td colspan=\"2\">\n";
    if ($ary_to_html["client_branch"] != null){
    $html_s .= "            <b>顧客担当支店</b> ".$ary_to_html["client_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["attach_branch"] != null){
    $html_s .= "            <b>所属本支店</b> ".$ary_to_html["attach_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1000px\">\n";
    $html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"250px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">仕入先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">仕入担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">".$ary_to_html["c_staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">部署</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">".$ary_to_html["part"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["buy_day"]."\">仕入日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["buy_day"]."\">".$ary_to_html["buy_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\" rowspan=\"2\">仕入担当者<br>（複数選択）<br></td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\" rowspan=\"2\">\n";
    $html_s .= "            ".$ary_to_html["multi_staff"].(($ary_to_html["multi_staff"] != null) ? "<br>例）0001,0002\n" : "\n");
    $html_s .= "        </td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\" rowspan=\"2\">倉庫</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\" rowspan=\"2\">".$ary_to_html["ware"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["trade"]."\">取引区分</td>\n";
    $html_s .= "        <td class=\"".$ary_td["trade"]."\">".$ary_to_html["trade"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（本部仕入）
/****************************/
function Search_Table_Buy_H($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "output_type",
        "client",
        "c_staff",
        "ware",
        "buy_day",
        "multi_staff",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「仕入先」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td colspan=\"2\">\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["output_type"] != null){
    $html_s .= "            <b>出力形式</b> ".$ary_to_html["output_type"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1060px\">\n";
    $html_s .= "    <col width=\"120px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"250px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">仕入先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">仕入担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">".$ary_to_html["c_staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">倉庫</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">".$ary_to_html["ware"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["buy_day"]."\">仕入日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["buy_day"]."\">".$ary_to_html["buy_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\">仕入担当複数選択</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\" colspan=\"3\">\n";
    $html_s .= "            ".$ary_to_html["multi_staff"].(($ary_to_html["multi_staff"] != null) ? " 例）0001,0002\n" : "\n");
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（支払）
/****************************/
function Search_Table_Payout($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "client_branch",
        "client",
        "pay_no",
        "pay_day",
        "sum_amount",
        "input_day",
        "account_day",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「仕入先」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>";
    $html_s .= "    </tr>\n";
    if ($ary_to_html["client_branch"] != null){
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td><b>顧客担当支店</b> ".$ary_to_html["client_branch"]."<br></td>\n";
    $html_s .= "    </tr>\n";
    }
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"100%\">\n";
    $html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">仕入先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_no"]."\">支払番号</td>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_no"]."\">".$ary_to_html["pay_no"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_day"]."\">支払日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_day"]."\">".$ary_to_html["pay_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["sum_amount"]."\">合計金額</td>\n";
    $html_s .= "        <td class=\"".$ary_td["sum_amount"]."\">".$ary_to_html["sum_amount"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">入力日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">".$ary_to_html["input_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["account_day"]."\">決済日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["account_day"]."\">".$ary_to_html["account_day"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（本部支払）
/****************************/
function Search_Table_Payout_H($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "client",
        "pay_no",
        "pay_day",
        "sum_amount",
        "input_day",
        "account_day",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「仕入先」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"100%\">\n";
    $html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">仕入先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_no"]."\">支払番号</td>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_no"]."\">".$ary_to_html["pay_no"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_day"]."\">支払日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_day"]."\">".$ary_to_html["pay_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["sum_amount"]."\">合計金額</td>\n";
    $html_s .= "        <td class=\"".$ary_td["sum_amount"]."\">".$ary_to_html["sum_amount"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">入力日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">".$ary_to_html["input_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["account_day"]."\">決済日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["account_day"]."\">".$ary_to_html["account_day"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（発注）
/****************************/
function Search_Table_Ord($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "client_branch",
        "attach_branch",
        "client",
        "c_staff",
        "part",
        "ord_day",
        "ord_no",
        "multi_staff",
        "ware",
        "hope_day",
        "direct",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null || $ary_to_html["direct"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「発注先」";
        }
        if ($ary_to_html["direct"] != null){
            $form_name[] = "「直送先」";
        }
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td colspan=\"2\">\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["client_branch"] != null){
    $html_s .= "            <b>顧客担当支店</b> ".$ary_to_html["client_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["attach_branch"] != null){
    $html_s .= "            <b>所属本支店</b> ".$ary_to_html["attach_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1000px\">\n";
    $html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"250px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">発注先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">発注担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">".$ary_to_html["c_staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">部署</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">".$ary_to_html["part"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["ord_day"]."\">発注日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ord_day"]."\">".$ary_to_html["ord_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\" rowspan=\"2\">発注担当者<br>（複数選択）<br></td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\" rowspan=\"2\">\n";
    $html_s .= "            ".$ary_to_html["multi_staff"].(($ary_to_html["multi_staff"] != null) ? "<br>例）0001,0002\n" : "\n");
    $html_s .= "        </td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\" rowspan=\"2\">倉庫</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\" rowspan=\"2\">".$ary_to_html["ware"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["ord_no"]."\">発注番号</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ord_no"]."\">".$ary_to_html["ord_no"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["hope_day"]."\">希望納期</td>\n";
    $html_s .= "        <td class=\"".$ary_td["hope_day"]."\">".$ary_to_html["hope_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["hope_day"]."\">直送先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["direct"]."\" colspan=\"3\">".$ary_to_html["direct"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（本部発注）
/****************************/
function Search_Table_Ord_H($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "client",
        "c_staff",
        "ware",
        "ord_day",
        "multi_staff",
        "ord_no",
        //"arrival_day",
        "hope_day",
        "direct",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null || $ary_to_html["direct"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「発注先」";
        }
        if ($ary_to_html["direct"] != null){
            $form_name[] = "「直送先」";
        }
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td colspan=\"2\">\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1030px\">\n";
    $html_s .= "    <col width=\" 70px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"150px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"250px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">発注先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">発注担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["c_staff"]."\">".$ary_to_html["c_staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">倉庫</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ware"]."\">".$ary_to_html["ware"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["ord_day"]."\">発注日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ord_day"]."\">".$ary_to_html["ord_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\">発注担当者複数選択</td>\n";
    $html_s .= "        <td class=\"".$ary_td["multi_staff"]."\" colspan=\"3\">\n";
    $html_s .= "            ".$ary_to_html["multi_staff"].(($ary_to_html["multi_staff"] != null) ? " 例）0001,0002\n" : "\n");
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["ord_no"]."\">発注番号</td>\n";
    $html_s .= "        <td class=\"".$ary_td["ord_no"]."\">".$ary_to_html["ord_no"]."</td>\n";
    //$html_s .= "        <td class=\"".$ary_td["arrival_day"]."\">入荷予定日</td>\n";
    //$html_s .= "        <td class=\"".$ary_td["arrival_day"]."\" colspan=\"3\">".$ary_to_html["arrival_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["hope_day"]."\">希望納期</td>\n";
    $html_s .= "        <td class=\"".$ary_td["hope_day"]."\" colspan=\"3\">".$ary_to_html["hope_day"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["direct"]."\">直送先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["direct"]."\" colspan=\"5\">".$ary_to_html["direct"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（請求）
/****************************/
function Search_Table_Claim($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "output_type",
        "client_branch",
        "attach_branch",
        "client",
        "round_staff",
        "part",
        "claim",
        "amount_this",
        "close_day",
        "collect_day",
        "charge_fc",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null || $ary_to_html["claim"] != null || ($ary_to_html["charge_fc"] != null || $_SESSION["group_kind"] == "2")){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「得意先」";
        }       
        if ($ary_to_html["claim"] != null){
            $form_name[] = "「請求先」";
        }       
        if ($ary_to_html["charge_fc"] != null && $_SESSION["group_kind"] == "2"){
            $form_name[] = "「委託先FC」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["output_type"] != null){
    $html_s .= "            <b>出力形式</b> ".$ary_to_html["output_type"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["client_branch"] != null){
    $html_s .= "            <b>顧客担当支店</b> ".$ary_to_html["client_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["attach_branch"] != null){
    $html_s .= "            <b>所属本支店</b> ".$ary_to_html["attach_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1000px\">\n";
    $html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"260px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">得意先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["round_staff"]."\">巡回担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["round_staff"]."\">".$ary_to_html["round_staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">部署</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">".$ary_to_html["part"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">請求先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">".$ary_to_html["claim"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["amount_this"]."\">請求額</td>\n";
    $html_s .= "        <td class=\"".$ary_td["amount_this"]."\" colspan=\"3\">".$ary_to_html["amount_this"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["close_day"]."\">請求締日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["close_day"]."\">".$ary_to_html["close_day"]."</td>\n";
    if ($_SESSION["group_kind"] == "2"){
    $html_s .= "        <td class=\"".$ary_td["charge_fc"]."\" rowspan=\"2\">委託先FC</td>\n";
    $html_s .= "        <td class=\"".$ary_td["charge_fc"]."\" rowspan=\"2\" colspan=\"3\">".$ary_to_html["charge_fc"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["collect_day"]."\">回収予定日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["collect_day"]."\">".$ary_to_html["collect_day"]."</td>\n";
    }else{
    $html_s .= "        <td class=\"".$ary_td["collect_day"]."\">回収予定日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["collect_day"]."\" colspan=\"3\">".$ary_to_html["collect_day"]."</td>\n";
    }
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（本部請求）
/****************************/
function Search_Table_Claim_H($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "output_type",
        "client",
        "sv_staff",
        "claim",
        "amount_this",
        "close_day",
        "collect_day",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null || $ary_to_html["claim"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「FC・取引先」";
        }       
        if ($ary_to_html["claim"] != null){
            $form_name[] = "「請求先」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name";
    $html_s .= "        </td>\n";
    if ($ary_to_html["output_type"] != null){
    $html_s .= "        <td align=\"right\"><b>出力形式</b> ".$ary_to_html["output_type"]."<br></td>\n";
    }
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\">\n";
    $html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"350px\">\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">FC・取引先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["sv_staff"]."\">担当者（SV）</td>\n";
    $html_s .= "        <td class=\"".$ary_td["sv_staff"]."\">".$ary_to_html["sv_staff"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">請求先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["claim"]."\">".$ary_to_html["claim"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["amount_this"]."\">請求額</td>\n";
    $html_s .= "        <td class=\"".$ary_td["amount_this"]."\">".$ary_to_html["amount_this"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["close_day"]."\">請求締日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["close_day"]."\">".$ary_to_html["close_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["collect_day"]."\">回収予定日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["collect_day"]."\" colspan=\"3\">".$ary_to_html["collect_day"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// 共通検索テーブルHTML（前受金）
/****************************/
function Search_Table_Advance($form){

    // フォームリスト
    $ary_list = array(
        "display_num",
        "client_branch",
        "attach_branch",
        "client",
        "staff",
        "part",
        "pay_day",
        "advance_no",
        "input_day",
        "amount",
        "bank",
        "b_bank",
        "account_no",
        "deposit_kind",
        "fix",
    );

    // toHtmlリスト、tdリストを作成
    list($ary_to_html, $ary_td) = Fnc_Search_Table($form, $ary_list);

    // 説明文作成
    if ($ary_to_html["client"] != null){
        $form_name      = null; 
        $disp_form_name = null; 
        if ($ary_to_html["client"] != null){
            $form_name[] = "「得意先」";
        }       
        $disp_form_name  = "　　<span style=\"color: #0000ff; font-weight: bold;\">・";
        foreach ($form_name as $key => $value){
            $disp_form_name .= $value; 
        }       
        $disp_form_name .= "検索は名前もしくは略称です</span>\n";
    }

    // 検索テーブル作成
    $html_s .= "\n";
    $html_s .= "<table width=\"100%\">\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td colspan=\"2\">\n";
    if ($ary_to_html["display_num"] != null){
    $html_s .= "            <b>表示件数</b> ".$ary_to_html["display_num"]."\n";
    }
    $html_s .= "            $disp_form_name\n";
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr style=\"color: #555555;\">\n";
    $html_s .= "        <td>\n";
    if ($ary_to_html["client_branch"] != null){
    $html_s .= "            <b>顧客担当支店</b> ".$ary_to_html["client_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "        <td align=\"right\">\n";
    if ($ary_to_html["attach_branch"] != null){
    $html_s .= "            <b>所属本支店</b> ".$ary_to_html["attach_branch"]."<br>\n";
    }
    $html_s .= "        </td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "<br style=\"font-size: 4px;\">\n";
    $html_s .= "<table class=\"Table_Search\" width=\"1000px\">\n";
    $html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"300px\">\n";
    $html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col width=\"250px\">\n";
    $html_s .= "    <col width=\" 40px\" style=\"font-weight: bold;\">\n";
    $html_s .= "    <col>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">得意先</td>\n";
    $html_s .= "        <td class=\"".$ary_td["client"]."\">".$ary_to_html["client"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["staff"]."\">担当者</td>\n";
    $html_s .= "        <td class=\"".$ary_td["staff"]."\">".$ary_to_html["staff"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">部署</td>\n";
    $html_s .= "        <td class=\"".$ary_td["part"]."\">".$ary_to_html["part"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_day"]."\">入金日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["pay_day"]."\">".$ary_to_html["pay_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["advance_no"]."\">伝票番号</td>\n";
    $html_s .= "        <td class=\"".$ary_td["advance_no"]."\" colspan=\"3\">".$ary_to_html["advance_no"]."\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">入力日</td>\n";
    $html_s .= "        <td class=\"".$ary_td["input_day"]."\">".$ary_to_html["input_day"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["amount"]."\">金額</td>\n";
    $html_s .= "        <td class=\"".$ary_td["amount"]."\" colspan=\"3\">".$ary_to_html["amount"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["bank"]."\">銀行</td>\n";
    $html_s .= "        <td class=\"".$ary_td["bank"]."\">".$ary_to_html["bank"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["b_bank"]."\">支店</td>\n";
    $html_s .= "        <td class=\"".$ary_td["b_bank"]."\" colspan=\"3\">".$ary_to_html["b_bank"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["account_no"]."\">口座番号</td>\n";
    $html_s .= "        <td class=\"".$ary_td["account_no"]."\">".$ary_to_html["account_no"]."</td>\n";
    $html_s .= "        <td class=\"".$ary_td["deposit_kind"]."\">預金種目</td>\n";
    $html_s .= "        <td class=\"".$ary_td["deposit_kind"]."\" colspan=\"3\">".$ary_to_html["deposit_kind"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "    <tr>\n";
    $html_s .= "        <td class=\"".$ary_td["fix"]."\">前受金確定</td>\n";
    $html_s .= "        <td class=\"".$ary_td["fix"]."\" colspan=\"5\">".$ary_to_html["fix"]."</td>\n";
    $html_s .= "    </tr>\n";
    $html_s .= "</table>\n";
    $html_s .= "\n";

    return $html_s;

}


/****************************/
// toHtmlリスト、td色リスト作成
/****************************/
function Fnc_Search_Table($form, $ary_form_list){

    // フォームリストでループ
    foreach ($ary_form_list as $key => $value){

        // フォームが存在する場合
        if ($form->elementExists("form_".$value) == true){
            // フォームをtoHtml
            $ary_to_html[$value] = $form->_elements[$form->_elementIndex["form_".$value]]->toHtml();
            // セル背景を水色に
            $ary_td[$value]      = "Td_Search_1";
        // フォームが存在しない場合
        }else{
            // フォームを出力しない
            $ary_to_html[$value] = null;
            // セル背景を灰色に
            $ary_td[$value]      = "Td_Search_2";
        }

    }

    return array($ary_to_html, $ary_td);

}


/****************************/
// 共通フォーム統合エラーチェック（売上）
/****************************/
/**
 * 概要     共通検索フォームの中で存在するフォームに対してエラーチェックを行う
 *
 * 説明     注）この関数を呼ぶ前に必ずフォーム作成（場合によってはRemove）を行っておくこと
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 *
 */
function Search_Err_Chk($form){

    // ■担当者
    if ($form->elementExists("form_round_staff") == true){
        $err_msg = "巡回担当者 は数値のみ入力可能です。";
        Err_Chk_Num($form, "form_round_staff", $err_msg);
    }

    // ■複数選択
    if ($form->elementExists("form_multi_staff") == true){
        $err_msg = "巡回担当者（複数選択） は数値と「,」のみ入力可能です。";
        Err_Chk_Delimited($form, "form_multi_staff", $err_msg);
    }

    // ■予定巡回日
    if ($form->elementExists("form_round_day") == true){
        $err_msg = "予定巡回日 の日付が妥当ではありません。";
        Err_Chk_Date($form, "form_round_day", $err_msg);
    }

    // ■請求日
    if ($form->elementExists("form_claim_day") == true){
        $err_msg = "請求日 の日付が妥当ではありません。";
        Err_Chk_Date($form, "form_claim_day", $err_msg);
    }

}


/****************************/
// フォーム個別エラーチェック関数
/****************************/
/**
 * 概要     指定されたデリミタで区切った場合の半角数値エラーチェック
 *
 * 説明     
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $err_msg    エラーメッセージ
 * @param string    $delimiter  区切り文字
 *
 */
function Err_Chk_Delimited($form, $form_name, $err_msg, $delimiter = ","){

    // $delimiter区切りの半角数字チェック
    if($_POST[$form_name] != null){
        $ary_multi_staff = explode($delimiter, $_POST[$form_name]);
        foreach ($ary_multi_staff as $key => $value){
            if (!ereg("^[0-9]+$", trim($value))){
                $form->setElementError($form_name, $err_msg);
                break;
            }
        }
    }

}


/**
 * 概要     数値[0-9]のエラーチェック
 *
 * 説明     伝票番号の範囲検索フォーム用
 *          範囲でない場合は文字列として扱えるためエラーチェックは必要ない
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $err_msg    エラーメッセージ
 *
 */
function Err_Chk_Num($form, $form_name, $err_msg){

    // キーと値を配列にセット
    $ary_keys = array_keys($_POST[$form_name]);
    $ary_vals = array_values($_POST[$form_name]);

    // 数値[0-9]チェック
    $form->addGroupRule($form_name, array(
        $ary_keys[0] => array(array($err_msg, "regex", "/^[0-9]+$/")),
        $ary_keys[1] => array(array($err_msg, "regex", "/^[0-9]+$/")),
    ));

}


/**
 * 概要     数値[-0-9]フォームのエラーチェック
 *
 * 説明     金額の範囲検索フォーム用
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $err_msg    エラーメッセージ
 *
 */
function Err_Chk_Int($form, $form_name, $err_msg){

    // キーと値を配列にセット
    $ary_keys = array_keys($_POST[$form_name]);
    $ary_vals = array_values($_POST[$form_name]);

    // 数値[-0-9]チェック
    $form->addGroupRule($form_name, array(
        $ary_keys[0] => array(array($err_msg, "regex", "/^[-]?[0-9]+$/")),
        $ary_keys[1] => array(array($err_msg, "regex", "/^[-]?[0-9]+$/")),
    ));

}


/**
 * 概要     日付フォームのエラーチェック
 *
 * 説明     必須チェック、数値チェック、日付としての妥当性チェック
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $err_msg    エラーメッセージ
 *
 */
function Err_Chk_Date($form, $form_name, $err_msg){

    // キーと値を配列にセット
    $ary_keys = array_keys($_POST[$form_name]);
    $ary_vals = array_values($_POST[$form_name]);

    // 必須チェック
    if ($ary_vals[0] != null || $ary_vals[1] != null || $ary_vals[2] != null){
# 再遷移時にQuickFormのrequiredでチェックすると値があってもエラーになる。原因不明。
/*
        $form->addGroupRule($form_name, array(
            $ary_keys[0] => array(array($err_msg, "required")),
            $ary_keys[1] => array(array($err_msg, "required")),
            $ary_keys[2] => array(array($err_msg, "required")),
        ));
*/
        if (!ereg("^[0-9]+$",$ary_vals[0]) || !ereg("^[0-9]+$",$ary_vals[1]) || !ereg("^[0-9]+$",$ary_vals[2])){
            $form->setElementError($form_name, $err_msg);
        }
    }
    if (count($ary_keys) == "6"){
        if ($ary_vals[3] != null || $ary_vals[4] != null || $ary_vals[5] != null){
# 再遷移時にQuickFormのrequiredでチェックすると値があってもエラーになる。原因不明。
/*
            $form->addGroupRule($form_name, array(
                $ary_keys[3] => array(array($err_msg, "required")),
                $ary_keys[4] => array(array($err_msg, "required")),
                $ary_keys[5] => array(array($err_msg, "required")),
            ));     
*/
            if (!ereg("^[0-9]+$",$ary_vals[3]) || !ereg("^[0-9]+$",$ary_vals[4]) || !ereg("^[0-9]+$",$ary_vals[5])){
                $form->setElementError($form_name, $err_msg);
            }
        }       
    }

    // 数値チェック
    if (count($ary_keys) == "3"){
        $form->addGroupRule($form_name, array(
            $ary_keys[0] => array(array($err_msg, "regex", "/^[0-9]+$/")),
            $ary_keys[1] => array(array($err_msg, "regex", "/^[0-9]+$/")),
            $ary_keys[2] => array(array($err_msg, "regex", "/^[0-9]+$/")),
        ));     
    }elseif (count($ary_keys) == "6"){
        $form->addGroupRule($form_name, array(
            $ary_keys[0] => array(array($err_msg, "regex", "/^[0-9]+$/")),
            $ary_keys[1] => array(array($err_msg, "regex", "/^[0-9]+$/")),
            $ary_keys[2] => array(array($err_msg, "regex", "/^[0-9]+$/")),
            $ary_keys[3] => array(array($err_msg, "regex", "/^[0-9]+$/")),
            $ary_keys[4] => array(array($err_msg, "regex", "/^[0-9]+$/")),
            $ary_keys[5] => array(array($err_msg, "regex", "/^[0-9]+$/")),
        ));     
    }

    // 妥当性チェック
    if ($ary_vals[0] != null || $ary_vals[1] != null || $ary_vals[2] != null){
        if (!checkdate((int)$ary_vals[1], (int)$ary_vals[2], (int)$ary_vals[0])){
            $form->setElementError($form_name, $err_msg);
        }
    }
    if (count($ary_keys) == "6"){
        if ($ary_vals[3] != null || $ary_vals[4] != null || $ary_vals[5] != null){
            if (!checkdate((int)$ary_vals[4], (int)$ary_vals[5], (int)$ary_vals[3])){
                $form->setElementError($form_name, $err_msg);
            }
        }
    }

}


?>
