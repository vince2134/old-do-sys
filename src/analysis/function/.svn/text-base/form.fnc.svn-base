<?php

/**
 * 概要     analysis 用フォームセット
 *
 * 説明     検索項目を生成する <br>
 *
 * 変更履歴 <br>
 * 2007-10-28   aizawa-m    商品名のmaxlengthを 15→30 に変更
 *
 *  項目                タイプ  フォーム名 <br>
 *  -------------------------------------------------------- <br>
 *  出力形式            radio   [form_output_type]  <br>
 *  取引年月(開始)      text    [form_trade_ym_s]   <br>
 *  取引年月(終了)      radio   [form_trade_ym_e]   <br>
 *  得意先              text    [form_client]       <br>
 *  商品(8桁)           text    [form_goods]        <br>
 *  粗利率              radio   [form_margin]       <br>
 *  表示対象            radio   [form_out_range]    <br>
 *  顧客区分            select  [form_rank]         <br>
 *  M区分               select  [form_g_goods]      <br>
 *  管理区分            select  [form_product]      <br>
 *  商品分類            select  [form_g_product]    <br>
 *  業種(大分類)        select  [form_lbtype]       <br>
 *  サービス名          select  [form_serv]         <br>
 *  グループ                    [form_cilent_gr]    <br>
 *  抽出対象            radio   [form_out_abstract] <br>
 *
 *
 * @param   object      $db_con         DB接続リソース
 * @param   string      $form           フォームオブジェクト
 * @param   array       $def_fdata      フォームデフォルト値配列（任意）
 *
 * @return  void
 *
 * ABC用の日付フォームを作成
 */
function Mk_Form ($db_con, $form, $def_fdata = null) {

    /****************************/
    // フォーム初期値設定
    /****************************/
    // フォーム初期値が渡されなかった場合
    if ($def_fdata == null){
        $def_fdata = array(
            "form_output_type"  => "1",
            "form_trade_ym_s"   => array("y" => date("Y"), "m" => "01"),
            "form_trade_ym_e"   => "12",
            "form_trade_ym_e_abc"   => "12",
            "form_margin"       => "1",
            //"form_out_amount"   => "1",
            "form_out_range"    => "1",
            "form_out_abstract" => "1",
        );
    }

    // フォーム初期値セット
    $form->setDefaults($def_fdata);

    /****************************/
    // フォーム定義
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // 出力形式
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "画面", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "CSV",  "2");
    $form->addGroup($obj, "form_output_type", "", " ");

    // 取引年月（開始）
    Addelement_Date_YM($form, "form_trade_ym_s", "取引年月", "-");

    // 取引年月（終了）
    $obj    =   null;
    //$obj[]  =&  $form->createElement("radio", null, null,  "今だけ1ヶ月", "1");
    //$obj[]  =&  $form->createElement("radio", null, null,  "今だけ2ヶ月", "2");
    $obj[]  =&  $form->createElement("radio", null, null,  "3ヶ月",  "3");
    $obj[]  =&  $form->createElement("radio", null, null,  "6ヶ月",  "6");
    $obj[]  =&  $form->createElement("radio", null, null, "12ヶ月", "12");
    $form->addGroup($obj, "form_trade_ym_e", "", " ");

    // 取引年月（終了）
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null,  "1ヶ月",  "1");
    $obj[]  =&  $form->createElement("radio", null, null,  "3ヶ月",  "3");
    $obj[]  =&  $form->createElement("radio", null, null,  "6ヶ月",  "6");
    $obj[]  =&  $form->createElement("radio", null, null, "12ヶ月", "12");
    $form->addGroup($obj, "form_trade_ym_e_abc", "", " ");

    // ショップ・得意先・仕入先コード(6桁-4桁 名称)
    // 仕入先コードとして使用する場合はtemplate側で子要素まで指定して下さい（コード2を出さないために）
    Addelement_Client_64n($form, "form_client", "", "-");

    // 商品（8桁）
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"30\" $g_form_option");
    $form->addGroup($obj, "form_goods", "", "");

    // 粗利率
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "表示",   "1");
    $obj[]  =&  $form->createElement("radio", null, null, "非表示", "2");
    $form->addGroup($obj, "form_margin", "", " ");

    // 出力金額（使わなくなっちゃった！）
    //$obj    =   null;
    //$obj[]  =&  $form->createElement("radio", null, null, "売上金額", "1");
    //$obj[]  =&  $form->createElement("radio", null, null, "粗利益額", "2");
    //$form->addGroup($obj, "form_out_amount", "", " ");

    // 表示対象
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "金額0以外", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "全て",      "2");
    $form->addGroup($obj, "form_out_range", "", " ");

    // 抽出対象 
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "東陽以外", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "全て",     "2");
    $form->addGroup($obj, "form_out_abstract", "", " ");

    // 顧客区分
    $item   =   null;
    $item   = Select_Get($db_con, "rank");
    $form->addElement("select", "form_rank", "", $item, $g_form_option_select);

    // Ｍ区分
    $item   =   null;
    $item   =   Select_Get($db_con, "g_goods");
    $form->addElement("select", "form_g_goods", "", $item, $g_form_option_select);

    // 管理区分
    $item   =   null;
    $item   =   Select_Get($db_con, "product");
    $form->addElement("select", "form_product", "", $item, $g_form_option_select);

    // 商品分類
    $item   =   null;
    $item   =   Select_Get($db_con, "g_product");
    $form->addElement("select", "form_g_product", "", $item, $g_form_option_select);

    // 担当者名
    $item   =   null;
    $item   =   Select_Get($db_con, "cstaff");
    $form->addElement("select", "form_staff", "", $item, $g_form_option_select);

    // 業種（大分類）
    $item   =   null;
    $item   =   Select_Get($db_con, "lbtype");
    $form->addElement("select", "form_lbtype","", $item, $g_form_option_select);

    // サービス名
    $item   =   null;
    $item   =   Select_Get($db_con, "serv");
    $form->addElement("select", "form_serv", "", $item, $g_form_option_select);

    // 所属本支店
    $item   =   null;
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_branch", "", $item, $g_form_option_select);

    // 部署 
    $item   =   null;
    $item   =   Select_Get($db_con, "part");
    $form->addElement("select", "form_part", "", $item, $g_form_option_select);

    // FC・得意先区分
    $item   =   null;
    $item   =   Select_Get($db_con, "rank");
    $form->addElement("select", "form_rank", "", $item, $g_form_option_select);

    // グループマスタ
    $obj    =   null;
    $item   =   null;
    $item   =   Select_Get($db_con, "client_gr");
    $obj[]  =&  $form->createElement("text", "name", "", "size=\"40\" maxlength=\"20\" onFocus=\"onForm(this);\" onBlur=\"blurForm(this);\"" );
    $obj[]  =&  $form->createElement("select", "cd", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_client_gr", "", " ");

    // ショップ・部署
    $obj    =   null;
    $item   =   null;
    $item   =   Make_Shop_Part_Hierselect($db_con);
    $obj    =&  $form->addElement("hierselect", "form_shop_part", "", "$g_form_option_select", " ");
    $obj->setOptions($item);

    // 表示ボタン
    $form->addElement("submit", "form_display", "表　示");

    // クリアボタン
    $form->addElement("button", "form_clear", "クリア", "onClick=\"javascript: location.href('".$_SERVER["PHP_SELF"]."');\"");

}


/**
 * 概要     HTML_QuickFormを利用して取引先コードの入力フォームを作成（6桁-4桁 取引先名）
 *
 * 説明     コード１・コード２・取引先名のフォーム名が指定されない場合、cd1, cd2, nameとなります<br>
 *
 * 変更履歴 <br>
 * 2007-10-28   aizawa-m    取引先名のmaxlenghtを 15→25 に変更 <br>
 *
 * @param   object      $form           HTML_QuickFormオブジェクト
 * @param   string      $form_name      HTMLでのフォーム名
 * @param   string      $label          表示名
 * @param   string      $ifs            区切り文字
 * @param   string      $cd1            コード１のフォーム名
 * @param   string      $cd2            コード２のフォーム名
 * @param   string      $name           取引先名のフォーム名
 * @param   string      $option         なにかあれば
 *
 * @return  object      $gr_obj         フォームオブジェクト
 *
 */
function Addelement_Client_64n ($form, $form_name, $label = "", $ifs = "", $cd1 = "cd1", $cd2 = "cd2", $name = "name", $option = ""){

    // global css
    global $g_form_option;

    // js用フォーム名
    $form_cd1       = "$form_name"."[".$cd1."]";
    $form_cd2       = "$form_name"."[".$cd2."]";

    // 属性とjs
    $sizelen_cd1    = "size=\"7\" maxLength=\"6\" ";
    $sizelen_cd2    = "size=\"4\" maxLength=\"4\" ";
    $sizelen_name   = "size=\"34\" maxLength=\"25\" ";
    $onkeyup_cd1    = "onkeyup=\"changeText(this.form, '$form_cd1', '$form_cd2', 6);\" ";
    $onkeydown      = "onKeyDown=\"chgKeycode();\" ";
    $onfocus        = "onFocus=\"onForm(this);\" ";
    $onblur         = "onBlur=\"blurForm(this);\" ";
    $form_option_64 = "class=\"ime_disabled\" ".$option;
    $form_option_n  = $option;

    // フォーム定義
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "$cd1", "", "$sizelen_cd1 $onkeyup_cd1 $onkeydown $onfocus $onblur $form_option_64");
    $obj[]  =&  $form->createElement("static", "", "", "$ifs");
    $obj[]  =&  $form->createElement("text", "$cd2", "", "$sizelen_cd2 $onkeydown $onfocus $onblur $form_option_64");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "$name", "", "$sizelen_name $onkeydown $g_form_option $form_option_n");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * 概要     HTML_QuickFormを利用して日付の入力フォームを作成
 *
 * 説明     年・月のフォーム名が指定されない場合、y, mとなります
 *
 * @param   object      $form           HTML_QuickFormオブジェクト
 * @param   string      $form_name      HTMLでのフォーム名
 * @param   string      $label          表示名
 * @param   string      $ifs            区切り文字
 * @param   string      $yy             年のフォーム名
 * @param   string      $mm             月のフォーム名
 * @param   string      $option         なにかあれば
 *
 * @return  object      $gr_obj         フォームオブジェクト
 *
 */
function Addelement_Date_YM ($form, $form_name, $label = "", $ifs = "", $yy = "y", $mm = "m", $option = "") {

    // js用フォーム名
    $form_y     = "$form_name"."[".$yy."]";
    $form_m     = "$form_name"."[".$mm."]";

    // 属性とjs
    $sizelen_y  = "size=\"4\" maxLength=\"4\" ";
    $sizelen_m  = "size=\"1\" maxLength=\"2\" ";
    $onkeyup_y  = "onkeyup=\"changeText(this.form, '$form_y', '$form_m', 4);\" ";
    $onfocus    = "onfocus=\"Onform_Thisyear_Jan_YM(this, this.form, '$form_name', '$form_y', '$form_m');\" ";
    $onblur     = "onBlur=\"blurForm(this);\" ";
    $onkeydown  = "onKeyDown=\"chgKeycode();\" ";
    $form_option= "class=\"ime_disabled\" ".$option;

    // フォーム定義
    $obj = null;
    $obj[] =& $form->createElement("text", "$yy", "", "$onkeyup_y $sizelen_y $onfocus $onblur $onkeydown $form_option");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    $obj[] =& $form->createElement("text", "$mm", "", "$sizelen_m $onfocus $onblur $onkeydown $form_option");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * 概要     ショップ、部署のヒアセレクトフォーム作成関数（本部用）
 *
 * 説明     ヒアセレクトは便利ですよーって。
 *
 * @param       $db_con     de-bi-konn
 *
 * @return      $res        ショップ、部署の配列
 *
 */
function Make_Shop_Part_Hierselect($db_con){

    // データ取得クエリ作成
    $sql  = "SELECT \n";
    $sql .= "   t_rank.rank_cd, \n";
    $sql .= "   t_rank.rank_name, \n";
    $sql .= "   t_client.client_id, \n";
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2  AS client_cd, \n";
    $sql .= "   t_client.client_cname, \n";
    $sql .= "   t_part.part_id, \n";
    $sql .= "   t_part.part_cd, \n";
    $sql .= "   t_part.part_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_rank \n";
    $sql .= "   LEFT JOIN t_client ON  t_rank.rank_cd       = t_client.rank_cd \n";
    $sql .= "   LEFT JOIN t_attach ON  t_client.client_id   = t_attach.shop_id \n";
    $sql .= "   LEFT JOIN t_part   ON  t_attach.part_id     = t_part.part_id   \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.client_div = '3' \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_rank.rank_cd, \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2, \n";
    $sql .= "   t_part.part_cd \n";
    $sql .= ";";

    // データ取得
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 1件以上ある場合
    if ($num > 0){

        for ($i=0; $i<$num; $i++){

            // データ取得（レコード毎）
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);

            // 各階層のIDを変数に代入
            $hier1_id = $data_list[$i]["rank_cd"];
            $hier2_id = $data_list[$i]["client_id"];
            $hier3_id = $data_list[$i]["part_id"];

            ///// 第1階層配列作成処理
            if ($data_list[$i]["rank_cd"] != $data_list[$i-1]["rank_cd"]){
                $ary_hier1[$hier1_id]  = $data_list[$i]["rank_cd"];
                $ary_hier1[$hier1_id] .= " ： ";
                $ary_hier1[$hier1_id] .= htmlentities($data_list[$i]["rank_name"], ENT_COMPAT, EUC);
            }

            ///// 第2階層配列作成処理
            if ($data_list[$i]["rank_cd"]   != $data_list[$i-1]["rank_cd"] ||
                $data_list[$i]["client_cd"] != $data_list[$i-1]["client_cd"]){
                if ($data_list[$i]["client_cd"] != null) {
                    $ary_hier2[$hier1_id][$hier2_id]  = $data_list[$i]["client_cd"];
                    $ary_hier2[$hier1_id][$hier2_id] .= " ： ";
                    $ary_hier2[$hier1_id][$hier2_id] .= htmlentities($data_list[$i]["client_cname"], ENT_COMPAT, EUC);
                }else{
                    $ary_hier2[$hier1_id][$hier2_id]  = null;
                }
            }

            ///// 第3階層配列作成処理
            if ($data_list[$i]["rank_cd"]   != $data_list[$i-1]["rank_cd"] ||
                $data_list[$i]["client_cd"] != $data_list[$i-1]["client_cd"] ||
                $data_list[$i]["part_cd"]   != $data_list[$i-1]["part_cd"]){
                if ($data_list[$i]["rank_cd"]   != $data_list[$i-1]["rank_cd"] ||
                    $data_list[$i]["client_cd"] != $data_list[$i-1]["client_cd"]){
                    $ary_hier3[$hier1_id][$hier2_id][null] = "";
                }
                if ($data_list[$i]["part_cd"] != null) {
                    $ary_hier3[$hier1_id][$hier2_id][$hier3_id]  = $data_list[$i]["part_cd"];
                    $ary_hier3[$hier1_id][$hier2_id][$hier3_id] .= " ： ";
                    $ary_hier3[$hier1_id][$hier2_id][$hier3_id] .= htmlentities($data_list[$i]["part_name"], ENT_COMPAT, EUC);
                } else {
                    $ary_hier3[$hier1_id][$hier2_id][$hier3_id]  = null;
                }
            }
        }

        // 1つの配列にまとて返す
        return array($ary_hier1, $ary_hier2, $ary_hier3);

    // 1件も無い場合
    }else{

        // 空の配列を返す
        $array[null] = "";
        return array($array, $array, $array);

    }

}


/**
 * 概要     年月フォームのエラーチェック
 *
 * 説明     必須チェック、数値チェック、日付としての妥当性チェック<br>
 *          関数内で setElementError する
 *
 * @param   object      $form       HTML_QuickFormオブジェクト
 * @param   string      $form_name  フォーム名（addGroup のグループ名）
 * @param   string      $err_msg    エラーメッセージ（任意）
 *
 * @return  void
 *
 */
function Err_Chk_Date_YM ($form, $form_name = null, $err_msg = null) {

    // POSTがある場合に処理を行う
    if ($_POST != null) {

        // 日付のフォーム名
        $form_name = ($form_name == null) ? "form_trade_ym_s" : $form_name;

        // エラーメッセージ定義
        $err_msg = ($err_msg == null) ? "集計期間 が正しくありません。" : $err_msg;

        // POSTされた日付フォームの値を配列にセット
        $ary_keys = array_keys($_POST[$form_name]);
        $ary_vals = array_values($_POST[$form_name]);

        // ■必須チェック
        $form->addGroupRule($form_name, array(
            $ary_keys[0] => array(array($err_msg, "required")),
            $ary_keys[1] => array(array($err_msg, "required")),
        ));

        // ■数値チェック
        $form->addGroupRule($form_name, array(
            $ary_keys[0] => array(array($err_msg, "regex", "/^[0-9]+$/")),
            $ary_keys[1] => array(array($err_msg, "regex", "/^[0-9]+$/")),
        ));

        // ■年月としての妥当性チェック
        // 年・月共に入力がある場合
        if ($ary_vals[0] != null && $ary_vals[1] != null){
            // 年・月が日付として正しいかチェック
            if (!checkdate((int)$ary_vals[1], 1, (int)$ary_vals[0])) {
                $form->setElementError($form_name, $err_msg);
            }
        }

    }

}

?>
