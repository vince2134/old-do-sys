<?php
/*
 * 変更履歴
 * 1.0.0 (2006/03/21) 構成数のフォーム変更(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.0.1 (2006/07/12)
*/

/*
 * バグ修正履歴
 * 1.0.0 (2006/03/21)
 * 製造品が選択されていないと、SQLエラーが表示される為、
 * 処理実行判定に、製造品のNULL判定を追加した(suzuki-t)
 *
 * 1.0.1 (2006/07/12) kaji
 * 登録ボタン押下後の確認画面に変更した内容が反映されていなバグ修正
 *
*/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/21　0077　　　　  watanabe-k　分子と分母に文字列を挿入した場合に分子のエラーしか表示されないバグの修正
 * 　2006/11/21　0078　　　　  watanabe-k　GETのIDチェック追加
 * 　2006/11/21　0078　　　　  watanabe-k　変更入力時にヘッダ部を変更ご行追加OR削除を行うと変更前に戻っているバグの修正
 *   2006-12-08  ban_0076      suzuki      登録・変更のログを残すように修正
 *   2007-01-24  仕様変更      watanabe-k  ボタンの色を変更
 *   2007-07-25                watanabe-k  親商品を変更した場合に元の親商品のフラグが変更されないバグの修正
 *   2007-09-06                watanabe-k  製造品の変更時に商品すうが10種類以上の場合表示されないバグの修正
 *
 */

$page_title = "製造品マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");
//DBに接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
$shop_id = $_SESSION["client_id"];
$get_goods_id = $_GET["goods_id"];
Get_Id_Check3($get_goods_id);
if($get_goods_id == null){
    $new_flg = true;
}else{
    $new_flg = false;
}

/****************************/
//初期設定
/****************************/
//表示行数
if(isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 10;
}
//削除行数
$del_history[] = null;

/****************************/
//行数追加
/****************************/
if($_POST["add_row_flg"]==true){
    //最大行に、＋１する
    $max_row = $_POST["max_row"]+1;
    //行数追加フラグをクリア
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//行削除処理
/****************************/
if(isset($_POST["del_row"])){

    //削除リストを取得
    $del_row = $_POST["del_row"];

    //削除履歴を配列にする。
    $del_history = explode(",", $del_row);
}

/***************************/
//初期値設定
/***************************/
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);

/*****************************/
//初期値セット
/*****************************/
//if($new_flg != true){
//if($new_flg != true && $_POST["form_entry_button"] != "登　録"){
if($new_flg != true && $_POST["first_set"] != 1){
    $get_sql  = "SELECT";
    $get_sql .= "   t_make.goods_cd,";
    $get_sql .= "   t_make.goods_name,";
    $get_sql .= "   t_parts.goods_cd,";
    $get_sql .= "   t_parts.goods_name,";
    $get_sql .= "   t_make_goods.denominator,";
    $get_sql .= "   t_make_goods.numerator";
    $get_sql .= " FROM";
    $get_sql .= "   t_make_goods,";
    $get_sql .= "   t_goods AS t_make,";
    $get_sql .= "   t_goods AS t_parts";
    $get_sql .= " WHERE";
    $get_sql .= "   t_make_goods.goods_id = $get_goods_id";
    $get_sql .= "   AND";
    $get_sql .= "   t_make_goods.goods_id = t_make.goods_id";
    $get_sql .= "   AND";
    $get_sql .= "   t_make_goods.parts_goods_id = t_parts.goods_id";
    $get_sql .= "   ORDER BY t_parts.goods_cd";
    $get_sql .= ";";

    $get_res = Db_query($conn, $get_sql);
    Get_Id_Check($get_res);

    $get_num = pg_num_rows($get_res);
    for($i = 0; $i < $get_num; $i++){
        $get_goods_data[] = pg_fetch_array($get_res, $i, PGSQL_NUM);
        
        $def_data["form_goods_cd"][$i]  = $get_goods_data[$i][2];
        $def_data["form_goods_name"][$i]  = $get_goods_data[$i][3];
        $def_data["form_denominator"][$i] = $get_goods_data[$i][4];
        $def_data["form_numerator"][$i]   = $get_goods_data[$i][5];
    
    }
    $def_data["form_make_goods"]["cd"] = $get_goods_data[0][0];
    $def_data["form_make_goods"]["name"] = $get_goods_data[0][1];
    
    //表示件数
    $max_row = $get_num;
    $def_data["max_row"] = $max_row;

    $form->setConstants($def_data);

    $id_data = Make_Get_Id($conn, "make_goods", $get_goods_data[0][0]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

}

/****************************/
//フォーム作成（固定）
/****************************/
$where  = " WHERE";
$where .= "     t_goods.public_flg = 't'";
$where .= "     AND";
$where .= "     t_goods.accept_flg = '1'";
$where .= "     AND";
$where .= "     t_goods.compose_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.state IN (1,3)";
$where .= "     AND";
$where .= "     t_goods.no_change_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.goods_id IN (SELECT goods_id FROM t_price where rank_cd = '1' AND shop_id = $shop_id)";

$code_value .= Code_Value("t_goods",$conn , $where);
$form_make_goods[] =& $form->createElement(
        "text","cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        onKeyUp=\"javascript:goods(this,'form_make_goods[name]')\" 
        ".$g_form_option."\""
    );
$form_make_goods[] =& $form->createElement(
        "text","name","","size=\"34\" 
                $g_text_readonly"
    );
$form->addGroup( $form_make_goods, "form_make_goods", "");

//button

//登録（ヘッダ）
//$form->addElement("button","new_button","登録画面","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","登録画面", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//変更・一覧
$form->addElement("button","change_button","変更・一覧","onClick=\"javascript:Referer('1-1-223.php')\"");

//hidden
$form->addElement("hidden", "del_row");             //削除行
$form->addElement("hidden", "add_row_flg");         //追加行フラグ
$form->addElement("hidden", "max_row");             //最大行数
$form->addElement("hidden", "first_set", "1");      //最大行数

/*****************************/
//POST情報取得
/*****************************/
$make_goods_cd = $_POST["form_make_goods"]["cd"];
$make_goods_name = $_POST["form_make_goods"]["name"];

for($i = 0; $i < $max_row; $i++){
    if($_POST["form_goods_cd"][$i] != null){
        $goods_cd[$i] = $_POST['form_goods_cd'][$i];
        $goods_name[$i] = $_POST["form_goods_name"][$i];

        $numerator[$i] = $_POST["form_numerator"][$i];
        $denominator[$i] = $_POST["form_denominator"][$i];

        $all_input_flg = true;
        $input_flg[$i] = true;
    }
}

/****************************/
//ルール作成（QuickForm）
/****************************/
//■製造品
//●必須チェック
$form->addGroupRule('form_make_goods', array(
        'cd' => array(
                array('製造品に正しい商品コードを入力して下さい。', 'required')
        ),      
        'name' => array(
                array('製造品に正しい商品コードを入力して下さい。','required')
        )      
));

/****************************/
//ルール作成（PHP）エラーの優先順位を考える必要有り？？
/****************************/
if($_POST["form_entry_button"] == "登　録"){

    /*****************************/
    //POST情報取得
    /*****************************/
    $make_goods_cd = $_POST["form_make_goods"]["cd"];
    $make_goods_name = $_POST["form_make_goods"]["name"];

    for($i = 0; $i < $max_row; $i++){
        if($_POST["form_goods_cd"][$i] != null){
            $goods_cd[$i] = $_POST['form_goods_cd'][$i];
            $goods_name[$i] = $_POST["form_goods_name"][$i];

            $numerator[$i] = $_POST["form_numerator"][$i];
            $denominator[$i] = $_POST["form_denominator"][$i];

            $all_input_flg = true;
            $input_flg[$i] = true;
        }
    }

    for($i = 0; $i < $max_row; $i++){
        //商品名
        //●必須チェック
        if($goods_cd[$i] != null && $goods_name[$i] == null){
            $goods_err = "部品に正しい商品コードを入力して下さい。";
            $err_flg = true;
        }

        //●同一商品が複数選択されている場合
        for($j = 0; $j < $max_row; $j++){
            if($input_flg[$i] == true && $i != $j && $goods_cd[$i] == $goods_cd[$j]){
                $used_goods_err = "部品に同じ商品が2回以上選択されています。";
                $err_flg = true;
            }
        }

        //●製造品と同じ商品が選択されている場合
        if($make_goods_cd === $goods_cd[$i]){
            $used_make_goods_err = "製造品と同じ商品が部品として選択されています。";
            $err_flg = true;
        }

        //■分子
        //●必須チェック
        if($numerator[$i] == null && $goods_name[$i] != null){
            $numerator_err = "数量（分子）は半角数字「1〜9」の1文字以上2文字以下です。";
            $err_flg = true;
        }

        //●数字チェック
        if($numerator[$i] != null  && !ereg("^[0-9]+$", $numerator[$i])){      
            $numerator_err = '数量（分子）は半角数字「1〜9」の1文字以上2文字以下です。';
            $err_flg = true;
        }       

        //■分母
        //●必須チェック
        if($denominator[$i] == null && $goods_name[$i] != null){
            $denominator_err = "数量（分母）は半角数字「1〜9」の1文字以上2文字以下です。";
            $err_flg = true;
        }

        //●数字チェック
        if($denominator[$i] != null  && !ereg("^[0-9]+$", $denominator[$i])){      
            $denominator_err = '数量（分母）は半角数字「1〜9」の1文字以上2文字以下です。';
            $err_flg = true; 
        } 

    }

    //●部品が全てnull
    if($all_input_flg != true){
        $goods_input_err = "部品が一つも選択されていません。";
        $err_flg = true;

    //●既に製造品として登録されている場合
    }elseif($all_input_flg == true && $err_flg != true && $make_goods_cd != null){
        $make_goods_sql  = " SELECT";
        $make_goods_sql .= "    goods_id,";
        $make_goods_sql .= "    make_goods_flg";
        $make_goods_sql .= " FROM";
        $make_goods_sql .= "    t_goods";
        $make_goods_sql .= " WHERE";
        $make_goods_sql .= "    shop_id = $shop_id";
        $make_goods_sql .= "    AND";
        $make_goods_sql .= "    goods_cd = '$make_goods_cd'";
        $make_goods_sql .= ";";

        $make_goods_res = Db_query($conn, $make_goods_sql);
        $make_goods_id  = pg_fetch_result($make_goods_res, 0,0);
        $make_goods_flg = pg_fetch_result($make_goods_res, 0,1);

        if($new_flg == true && $make_goods_flg == 't'){
            $make_goods_flg_err = "製造品として選択した商品はすでに製造品として登録されています。";
            $err_flg = true;
        }elseif($new_flg == false && $make_goods_id != $get_goods_id && $make_goods_flg == 't'){
            $make_goods_flg_err = "製造品として選択した商品はすでに製造品として登録されています。";
            $err_flg = true;
        }elseif($new_flg == false && $make_goods_id != $get_goods_id && $make_goods_flg != 't'){
            $make_flg = true;
        }
    }
}

/****************************/
//検証
/****************************/
if($_POST["form_entry_button"] == "登　録" && $form->validate() && $err_flg != true){

    /*****************************/
    //登録処理
    /*****************************/
    Db_Query($conn, "BEGIN;");

    $insert_sql  = " UPDATE";
    $insert_sql .= "    t_goods";
    $insert_sql .= " SET";
    $insert_sql .= "    make_goods_flg = 't'";
    $insert_sql .= " WHERE";
    $insert_sql .= "    goods_id = $make_goods_id";
    $insert_sql .= ";";

    $result = Db_Query($conn, $insert_sql);
    if($result === false){
        Db_Query($conn, "ROLLBACK");
        exit;
    }

    $work_div = '1';

    //変更時
    if($new_flg == false){
        $insert_sql  = " DELETE FROM";
        $insert_sql .= "    t_make_goods";
        $insert_sql .= " WHERE";
        $insert_sql .= "    goods_id = $get_goods_id";
        $insert_sql .= ";";

        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        //変更前と変更後の製造品の商品IDが一致しない　かつ　変更後の製造品の「製造品フラグ＝f」
        if($make_flg == true){
            $insert_sql  = " UPDATE";
            $insert_sql .= "    t_goods";
            $insert_sql .= " SET";
            $insert_sql .= "    make_goods_flg = 'f'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    goods_id = $get_goods_id";
            $insert_sql .= ";";

            $result = Db_Query($conn,$insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }
        }

        $work_div = '2';

    }
    for($i = 0; $i < $max_row; $i++){
        if($input_flg[$i] == true){
            $insert_sql  = " INSERT INTO t_make_goods VALUES(";
            $insert_sql .= "    $make_goods_id,";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        goods_id";
            $insert_sql .= "      FROM";
            $insert_sql .= "        t_goods";
            $insert_sql .= "      WHERE";
            $insert_sql .= "        shop_id = $shop_id";
            $insert_sql .= "        AND";
            $insert_sql .= "        goods_cd = '$goods_cd[$i]'";
            $insert_sql .= "    ),";
            $insert_sql .= "    '$denominator[$i]',";
            $insert_sql .= "    '$numerator[$i]'";
            $insert_sql .= ");";

            $result = Db_Query($conn, "$insert_sql");
            if($result === false){
                Db_Queery($conn, "ROLLBACK");
                exit;
            }
        }
    }

    $result = Log_Save( $conn, "make_goods", $work_div,$make_goods_cd, $make_goods_name);
    if($result === false){
        Db_Queery($conn, "ROLLBACK");
        exit;
    }

    Db_Query($conn," COMMIT;");
    $freeze_flg = true;
}

if($freeze_flg == true){

    // 戻るボタンの遷移先ID取得
    // 新規登録時
    if ($get_goods_id == null){
        $get_id = $make_goods_id;
    // 変更時
    }else{
        $get_id = $get_goods_id;
    }

    $form->addElement("button","form_entry_button","Ｏ　Ｋ","onClick=\"location.href='./1-1-224.php'\"");
    $form->addElement("button","form_back_button","戻　る","onClick=\"location.href='".$_SERVER["PHP_SELF"]."?goods_id=$get_id'\"");
    
    $form->addElement("static","form_goods_link","","製造品","");
    $form->freeze();
}else{

    $form->addElement("submit","form_entry_button","登　録","onClick=\"javascript:return Dialogue('登録します。','#')\" $disabled");

    //次へボタン
    if($next_id != null){
        $form->addElement("button","next_button","次　へ","onClick=\"location.href='./1-1-224.php?goods_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","次　へ","disabled");
    }

    //前へボタン
    if($back_id != null){
        $form->addElement("button","back_button","前　へ","onClick=\"location.href='./1-1-224.php?goods_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","前　へ","disabled");
    }

    $form->addElement(
        "link","form_goods_link","","#","製造品",
        "onClick=\"return Open_SubWin('../dialog/1-0-210.php', Array('form_make_goods[cd]', 'form_make_goods[name]'), 500, 450);\""
    );

}

/*****************************/
//フォーム作成（変動）
/*****************************/
//行番号カウンタ
$row_num = 1;

if($freeze_flg == true){
    $style  = "color : #000000;"; 
    $style .= "border : #ffffff 1px solid;"; 
    $style .= "background-color: #ffffff;";

    $g_form_option = "readonly";
}

for($i = 0; $i < $max_row; $i++){

    //削除行判定
    if(!in_array("$i", $del_history)){
        //削除履歴
        $del_data = $del_row.",".$i;

        //商品コード
        $form_goods =& $form->addElement(
                "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
                onKeyUp=\"javascript:goods(this,'form_goods_name[$i]')\" 
                style=\"$style;$g_form_style\"
                ".$g_form_option."\"
            ");
        //商品名
        $form_good =& $form->addElement(
                "text","form_goods_name[$i]","","size=\"34\" maxLength=\"30\" 
                $g_text_readonly"
            );

        //構成数
        $form->addElement(
                "text","form_numerator[$i]","","size=\"3\" maxLength=\"3\" style=\"$style text-align: right;$g_form_style\"
                $g_form_option"
            );
        $form->addElement(
                "text","form_denominator[$i]","","size=\"3\" maxLength=\"3\" style=\"$style text-align: right;$g_form_style\"
                $g_form_option"
            );
        $form->addGroup($form_num, "form_count[$i]");

        /****************************/
        //表示用HTML作成
        /****************************/
        $html .= "<tr class=\"Result1\">\n";
        $html .=    "<td align=\"right\">$row_num</td>\n";

        //商品コード・商品名
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        if($freeze_flg != true){
            $html .=        "（<a href=\"#\" onClick=\"return Open_SubWin('../dialog/1-0-210.php', Array('form_goods_cd[$i]', 'form_goods_name[$i]'), 500, 450);\">検索</a>）";
        }
        $html .=    "</td>\n";
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>\n";

        //数量（分子/分母）
        $html .=    "<td align=\"center\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_numerator[$i]"]]->toHtml();
        $html .=        "/";
        $html .=        $form->_elements[$form->_elementIndex["form_denominator[$i]"]]->toHtml();
        $html .=    "</td>\n";
        if($freeze_flg != true){
            $html .=    "<td align=\"center\">";
            $html .=       "<a href=\"#\" onClick=\"javascript:Dialogue_1('削除します。', '$del_data', 'del_row')\">削除</a>";
            $html .=    "</td>\n";
        }
        $html .= "</tr>\n";

        //行番号を＋１
        $row_num = $row_num+1;
    }
}

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//全件数取得
/****************************/
$make_goods_sql  = " SELECT";
$make_goods_sql .= "    COUNT(t_goods.goods_id)";
$make_goods_sql .= " FROM";
$make_goods_sql .= "    t_goods";
$make_goods_sql .= " WHERE";
$make_goods_sql .= "    t_goods.shop_id = $shop_id";
$make_goods_sql .= "    AND";
$make_goods_sql .= "    t_goods.make_goods_flg = 't'";

//ヘッダーに表示させる全件数
$total_count_sql = $make_goods_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);

$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'               => "$html_header",
	'page_menu'                 => "$page_menu",
	'page_header'               => "$page_header",
	'html_footer'               => "$html_footer",
    'html'                      => "$html",
    'code_value'                => "$code_value",
    'goods_err'                 => "$goods_err",
    'numerator_err'             => "$numerator_err",
    'numerator_numeric_err'     => "$numerator_numeric_err",
    'denominator_err'           => "$denominator_err",
    'denominator_numeric_err'   => "$denominator_numeric_err",
    'used_goods_err'            => "$used_goods_err",
    'used_make_goods_err'       => "$used_make_goods_err",
    'make_goods_flg_err'        => "$make_goods_flg_err",
    'goods_input_err'           => "$goods_input_err",
    'next_id'                   => "$next_id",
    'back_id'                   => "$back_id",
    'freeze_flg'                => "$freeze_flg",
    'auth_r_msg'                => "$auth_r_msg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
