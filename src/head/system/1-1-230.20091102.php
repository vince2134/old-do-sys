<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/16　0064　　　　　watanabe-k　変更時は講整数文しか行を表示しないように修正
 * 　2006/11/16　0065　　　　　watanabe-k　同一商品は入力不可となるように修正
 * 　2006/11/16　0066　　　　　watanabe-k　GETチェック追加
 * 　2006/11/16　0067　　　　　watanabe-k　GETチェック追加
 * 　2006/11/16　0068　　　　　watanabe-k　GETチェック追加
 * 　2006/11/16　0069　　　　　watanabe-k　直営有効商品は部品に指定できないように修正
 * 　2006/11/16　0071　　　　　watanabe-k　承認フラグを登録するように修正
 * 　2006/11/16　0072　　　　　watanabe-k　行間を空けて登録してもOKとなるように修正
 *   2006-12-08  ban_0071      suzuki      登録・変更のログを残すように修正
 *   2007-01-22  仕様変更      watanabe-k  ボタンの色を変更
 *   2007-06-25                watanabe-k  構成品の変更を契約マスタと予定データに反映する。
 *   2009-10-08  仕様変更      hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *
 */


$page_title = "構成品マスタ";

//環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //契約関連の関数

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

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
if($get_goods_id != null){
    Get_Id_Check3($get_goods_id);
    $update_flg = true;
}else{
    $update_flg = false;
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
if($_POST["add_flg"]==true){
    //最大行に、＋１する
    $max_row = $_POST["max_row"]+1;
    //行数追加フラグをクリア
    $add_row_data["add_flg"] = "";
    $add_row_data["max_row"] = $max_row;
    $form->setConstants($add_row_data);
}

/****************************/
//行削除処理
/****************************/
if(isset($_POST["delete_row"])){
    //削除リストを取得
    $delete_row = $_POST["delete_row"];

    //削除履歴を配列にする。
    $del_history = explode(",", $delete_row);
}

/***************************/
//初期値設定
/***************************/
$def_data["form_tax_div"]       = 1;
$def_data["form_name_change"]       = 1;
$def_data["form_state_type"]       = 1;
$def_data["form_accept"]       = "2";
$def_data["max_row"]            = $max_row;
//初期値設定
$form->setDefaults($def_data);


/****************************/
//フォーム作成（固定）
/****************************/
//状態
$form_state[] =& $form->createElement( "radio",NULL,NULL, "有効","1");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "無効","2");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "有効（直営）","3");
$form->addGroup($form_state, "form_state_type", "状態");

//承認ラジオボタン
$form_accept[] =& $form->createElement("radio", null, null, "承認済", "1");
$form_accept[] =& $form->createElement("radio", null, null, "未承認", "2");
$form->addGroup($form_accept, "form_accept", "");

//構成品コード
$where  = " WHERE";
$where .= "     t_goods.public_flg = 't'";
$where .= "     AND";
$where .= "     t_goods.accept_flg = '1'";
$where .= "     AND";
$where .= "     t_goods.compose_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.no_change_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.state = '1'";

$code_value = Code_Value("t_goods",$conn, $where);
$form->addElement(
        "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        $g_form_option"
);

//構成品名
$form->addElement(
        "text","form_goods_name","",'size="34" maxLength="30"
         '." $g_form_option"
);

//略称
$form->addElement(
        "text","form_goods_cname","",'size="34" maxLength="10"
         '." $g_form_option"
);

//単位
$form->addElement(
        "text","form_unit","",'size="5" maxLength="5"
         '." $g_form_option"
);

//品名変更
$name_change[] =& $form->createElement( "radio",NULL,NULL, "変更可","1");
$name_change[] =& $form->createElement( "radio",NULL,NULL, "変更不可","2");
$form->addGroup( $name_change, "form_name_change", "");
$form->addElement($type,"form_name_change_name","","size=\"10\" maxLength=\"8\"
       $g_form_option"
);

//課税区分
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "外税","1");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "課税","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "内税","2");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "非課税","3");
$form->addGroup( $tax_div, "form_tax_div", "");
$form->addElement($type,"form_tax_div_name","","size=\"10\" maxLength=\"8\"
       $g_form_option"
);

//button
//登録（ヘッダ）
//$form->addElement("button","new_button","登　録","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","登　録",$g_button_color."  onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//変更・一覧
$form->addElement("button","change_button","変更・一覧","onClick=\"javascript:location.href='./1-1-229.php'\"");

$form->addElement("submit","form_total_button","自動計算","#");

//hidden
$form->addElement("hidden", "delete_row");          //削除行
$form->addElement("hidden", "add_flg");             //追加行フラグ
$form->addElement("hidden", "max_row");             //最大行数
$form->addElement("hidden", "search_row");          //商品検索フラグ

$rank_name = array("付加","標準価格");
for($i = 0; $i < 2; $i++){
    //顧客区分ごとにフォームを作成
    $form->addElement(
        "text","form_rank_price[$i]","$rank_name[$i]",
        "style =\"color : #000000;
        text-align : right;
        border : #ffffff 1px solid;
        background-color: #ffffff;\"
        readonly"
    );      
}

//エラー埋め込み用フォーム作成
$form->addElement("text","price_err","","");
$form->addElement("text","parts_goods_err","","");
$form->addElement("text","count_err","","");

/***************************/
//更新データ設定
/***************************/
if($update_flg === true){

    //親商品情報を抽出
    $sql  = "SELECT\n";
    $sql .= "    t_goods.goods_cd,\n";
    $sql .= "    t_goods.goods_name,\n";
    $sql .= "    t_goods.goods_cname,\n";
    $sql .= "    t_goods.unit,\n";
    $sql .= "    t_goods.tax_div,\n";
    $sql .= "    t_goods.state,\n";
    $sql .= "    t_goods.name_change,\n";
    $sql .= "    t_goods.accept_flg ";
    $sql .= " FROM\n";
    $sql .= "    t_goods\n";
    $sql .= " WHERE\n";
    $sql .= "    t_goods.goods_id = $get_goods_id\n";
    $sql .= "    AND\n";
    $sql .= "    t_goods.compose_flg = 't'\n";
    $sql .= "    AND\n";
    $sql .= "    t_goods.shop_id = $shop_id\n";
    $sql .= ";\n";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);
    $num = pg_num_rows($result);
    $set_goods_data = pg_fetch_array($result, 0);

    //取得した親商品のデータをセット
    $set_update_data["form_goods_cd"]       = $set_goods_data["goods_cd"];
    $set_update_data["form_goods_name"]     = $set_goods_data["goods_name"];
    $set_update_data["form_goods_cname"]    = $set_goods_data["goods_cname"];
    $set_update_data["form_unit"]           = $set_goods_data["unit"];
    $set_update_data["form_state_type"]     = $set_goods_data["state"];
    $set_update_data["form_name_change"]    = $set_goods_data["name_change"];
    $set_update_data["form_tax_div"]        = $set_goods_data["tax_div"];
    $set_update_data["form_accept"]         = $set_goods_data["accept_flg"];

    $def_goods_cd = $set_goods_data["goods_cd"];
    
    //子の商品のデータを抽出
    $sql  = "SELECT \n";
    $sql .= "    t_goods.goods_cd,\n";
    $sql .= "    t_goods.goods_name,\n";
    $sql .= "    t_price.r_price,\n";
    $sql .= "    t_price2.r_price AS price,\n";
    $sql .= "    t_goods.count\n";
    $sql .= " FROM\n";
    $sql .= "    (SELECT\n";
    $sql .= "        t_goods.goods_id,\n";
    $sql .= "        t_goods.goods_cd,\n";
    $sql .= "        t_goods.goods_name,\n";
    $sql .= "        t_compose.count\n";
    $sql .= "     FROM\n";
    $sql .= "        t_goods\n";
    $sql .= "            INNER JOIN\n";
    $sql .= "        t_compose\n";
    $sql .= "        ON t_goods.goods_id = t_compose.parts_goods_id\n";
    $sql .= "     WHERE\n";
    $sql .= "        t_compose.goods_id = $get_goods_id\n";
    $sql .= "    ) AS t_goods\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_price\n";
    $sql .= "    ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_price AS t_price2\n";
    $sql .= "    ON t_goods.goods_id = t_price2.goods_id\n";
    $sql .= " WHERE\n";
    $sql .= "    t_price.rank_cd = '1'\n";
    $sql .= "    AND\n";
    $sql .= "    t_price.shop_id = $shop_id\n";
    $sql .= "    AND\n";
    $sql .= "    t_price2.rank_cd = '4'\n";
    $sql .= "    AND\n";
    $sql .= "    t_price2.shop_id = $shop_id\n";
    $sql .= " ;\n"; 

    $result = Db_Query($conn, $sql);
    $parts_num = pg_num_rows($result);
    for($i = 0; $i < $parts_num; $i++){
        $set_parts_goods_data[$i] = pg_fetch_array($result, $i);
    }

    //セットする配列作成
    for($i = 0; $i < $parts_num; $i++){
        $set_update_data["form_parts_goods_cd"][$i]   = $set_parts_goods_data[$i]["goods_cd"];
        $set_update_data["form_parts_goods_name"][$i] = $set_parts_goods_data[$i]["goods_name"];
        $set_update_data["form_buy_price"][$i] = number_format($set_parts_goods_data[$i]["r_price"],2);
        $set_update_data["form_count"][$i]            = $set_parts_goods_data[$i]["count"];
        //単価
        $price = bcmul($set_parts_goods_data[$i]["price"],$set_parts_goods_data[$i]["count"],2);
        $buy_total = bcmul($set_parts_goods_data[$i]["r_price"],$set_parts_goods_data[$i]["count"],2);
        $set_update_data["form_buy_money"][$i] = number_format($buy_total,2);

        //付加
        $buy_amount1 = bcadd($buy_amount1, $buy_total,2);
        //標準売価
        $buy_amount2 = bcadd($buy_amount2, $price,2);
    }

    $max_row = $parts_num;

    $set_update_data["form_rank_price"][0] = $buy_amount1;
    $set_update_data["form_rank_price"][1] = $buy_amount2;

    $form->setDefaults($set_update_data);
    //次へ
    $id_data = Make_Get_Id($conn, "compose",$set_goods_data["goods_cd"]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];
}

/****************************/
//自動計算ボタン表示処理
/****************************/
if($_POST["form_total_button"] == "自動計算" || $_POST["form_entry_button"] == "登　録"){

    //部品データ取得
    for($i = 0; $i < $max_row; $i++){
        if($_POST["form_parts_goods_cd"][$i] != null){
            $parts_goods_cd[$i]   = $_POST['form_parts_goods_cd'][$i];
            $parts_goods_name[$i] = $_POST["form_parts_goods_name"][$i];
            $count[$i]            = $_POST["form_count"][$i];

            //部品に選択された商品の単価を抽出
            $sql  = "SELECT\n";
            $sql .= "   t_price.r_price\n";
            $sql .= " FROM\n";
            $sql .= "   t_price\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   (SELECT\n";
            $sql .= "       goods_id\n";
            $sql .= "   FROM\n";
            $sql .= "       t_goods\n";
            $sql .= "   WHERE\n";
            $sql .= "       goods_cd = '$parts_goods_cd[$i]'\n";
            $sql .= "       AND\n";
            $sql .= "       shop_id = $shop_id\n";
            $sql .= "   ) AS t_goods\n";
            $sql .= "   ON t_price.goods_id = t_goods.goods_id\n";
            $sql .= " WHERE\n";
            $sql .= "   t_price.rank_cd IN ('1','4')\n";
            $sql .= "   AND\n";
            $sql .= "   t_price.shop_id = $shop_id\n";
            $sql .= ";";

            $result = Db_Query($conn, $sql);

            for($j = 0; $j < 2; $j++){
                $buy_money = bcmul($count[$i], pg_fetch_result($result,$j,0),2);
                $total_price[$j] = bcadd($total_price[$j],$buy_money,2);
            }
        }
    }

    //計算結果をセット
    for($i = 0; $i < 2; $i++){
        $set_price_data["form_rank_price[$i]"] = $total_price[$i];
    }

    $form->setConstants($set_price_data);
}

/****************************/
//登録ボタン押下処理
/****************************/
if($_POST["form_entry_button"] == "登　録"){

    /*****************************/
    //POST情報取得
    /*****************************/
    $state                  = $_POST["form_state_type"];        //状態
    $goods_cd               = $_POST["form_goods_cd"];          //構成品コード
    $goods_name             = $_POST["form_goods_name"];        //構成品名
    $goods_cname            = $_POST["form_goods_cname"];       //略称
    $unit                   = $_POST["form_unit"];              //単位
    $tax_div                = $_POST["form_tax_div"];           //課税区分
    $name_change            = $_POST["form_name_change"];        //品名変更
    $accept                 = $_POST["form_accept"];

    $j = 0;
    $parts_goods_cd = null;
    $parts_goods_name = null;
    $count = null;

    //部品データ取得
    for($i = 0; $i < $max_row; $i++){
        if($_POST["form_parts_goods_cd"][$i] != null){
            $parts_goods_cd[$j]   = $_POST['form_parts_goods_cd'][$i];
            $parts_goods_name[$j] = $_POST["form_parts_goods_name"][$i];
            $count[$j]            = $_POST["form_count"][$i];
            $j++;
        }
    }
    /****************************/
    //ルール作成（Quick_Formでチェック）
    /****************************/
    //■構成品コード
    //●必須チェック
    $form->addRule('form_goods_cd','構成品コードは8文字の半角数字です。', 'required');

    //●半角チェック
    $form->addRule('form_goods_cd','構成品コードは8文字の半角数字です。', "regex", "/^[0-9]+$/");

    //■構成品名
    //●必須チェック  
    $form->addRule('form_goods_name','構成品名は１文字以上30文字以下です。','required');
    // 全角/半角スペースのみチェック
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_goods_name", "構成品名 にスペースのみの登録はできません。", "no_sp_name");

    //■略称
    //●必須チェック
    $form->addRule('form_goods_cname','略称は1文字以上10文字以下です。','required'); 
    // 全角/半角スペースのみチェック
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_goods_cname", "略称 にスペースのみの登録はできません。", "no_sp_name");

    /****************************/
    //ルール作成（PHPでチェック）
    /****************************/
    //●コード体系チェック
    if($goods_cd != null && (strlen($goods_cd) >= 8) && substr($goods_cd, 0, 1) != 0){
        $form->setElementError("form_goods_cd","商品コードの上１桁は「０」です。");
    }

    //商品コード整形
    $goods_cd = str_pad($goods_cd, 8, 0, STR_PAD_LEFT);

    //商品コード空きチェック
    $sql  = " SELECT";
    $sql .= "     goods_cd";
    $sql .= " FROM";
    $sql .= "     t_goods";
    $sql .= " WHERE";
    $sql .= "     shop_id = $shop_id";
    $sql .= "     AND";
    $sql .= "     goods_cd = '$goods_cd'";
    $sql .= " ;";

    $result = Db_Query($conn, $sql);
    $db_goods_cd = @pg_fetch_result($result, 0,0);       //重複した商品コード

    if($db_goods_cd != null && $update_flg != true){
        $form->setElementError("form_goods_cd","既に使用されている 商品コード です。");
    }elseif($db_goods_cd != null && $update_flg == true && $def_goods_cd != $db_goods_cd){
        $form->setElementError("form_goods_cd","既に使用されている 商品コード です。");
    }

    //登録処理の場合
    if($_GET["goods_id"] == null){
        //商品入力チェック
        for($i = 0; $i < $max_row; $i++){
            if($parts_goods_name[$i] != null){
                $input_flg = true;
            }
        }

        if($input_flg != true){
            $form->setElementError("parts_goods_err","部品が一つも選択されていません。");
        }else{

            for($i = 0; $i < count($parts_goods_cd); $i++){
                //■商品
                //●必須チェック
                if($parts_goods_cd[$i] != "" && $parts_goods_name[$i] == null){
                    $form->setElementError("parts_goods_err","部品に正しい商品コードを入力して下さい。");
                }

                //■数量
                //●必須チェック
                if($count[$i] == null && $parts_goods_name[$i] != null){
                    $form->setElementError("count_err","数量は半角数字の1文字以上5文字以下です。");
                }

                //●数字チェック
                if($count[$i] != null  && !ereg("^[0-9]+$", $count[$i])){
                    $form->setElementError("count_err",'数量は半角数字の1文字以上5文字以下です。');
                }
        
                //●同一商品が複数選択されている場合
                for($j = 0; $j < count($parts_goods_cd); $j++){
                    if($i != $j && $parts_goods_cd[$i] == $parts_goods_cd[$j]){
                        $form->setElementError("parts_goods_err","構成品に同じ商品が複数選択されています。");
                        break;
                    }
                }
            }
        }
    }

    /****************************/
    //検証
    /****************************/
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /*****************************/
        //更新処理
        /*****************************/
        if($update_flg === true){
            //商品マスタの情報を変更
			$work_div = 2;

            $sql  = "UPDATE t_goods SET\n";
            $sql .= "   goods_cd = '$goods_cd',\n";
            $sql .= "   goods_name = '$goods_name',\n";
            $sql .= "   goods_cname = '$goods_cname',\n";
            $sql .= "   unit = '$unit',\n";
            $sql .= "   tax_div = '$tax_div',\n";
            $sql .= "   name_change = '$name_change',\n";
            $sql .= "   state = '$state',\n";
            $sql .= "   accept_flg = '$accept' ";
            $sql .= "WHERE\n";
            $sql .= "   goods_id = $get_goods_id\n";
            $sql .= ";\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //商品マスタの変更を契約マスタ、予定データに反映
            $result = Mst_Sync_Goods($conn,$get_goods_id,"name");
            if($result === false){
                exit;
            }

        /*****************************/
        //登録処理
        /*****************************/
        }else{
            //構成品を商品マスタに登録    
			$work_div = 1;

            $sql  = "INSERT INTO t_goods (\n";
            $sql .= "    goods_id\n,";
            $sql .= "    goods_cd,\n";
            $sql .= "    goods_name,\n";
            $sql .= "    goods_cname,\n";
            $sql .= "    unit,\n";
            $sql .= "    tax_div,\n";
            $sql .= "    name_change,\n";
            #2009-10-08 hashimoto-y
            #$sql .= "    stock_manage,\n";
            $sql .= "    compose_flg,\n";
            $sql .= "    state,\n";
            $sql .= "    public_flg,\n";
            $sql .= "    shop_id, \n";
            $sql .= "    accept_flg ";
            $sql .= " )VALUES(\n";
            $sql .= "    (SELECT COALESCE(MAX(goods_id),0)+1 FROM t_goods),\n";
            $sql .= "    '$goods_cd',\n";
            $sql .= "    '$goods_name',\n";
            $sql .= "    '$goods_cname',\n";
            $sql .= "    '$unit',\n";
            $sql .= "    '$tax_div',\n";
            $sql .= "    '$name_change',\n";
            #2009-10-08 hashimoto-y
            #$sql .= "    '2',\n";
            $sql .= "    't',\n";
            $sql .= "    '$state',\n";
            $sql .= "    't',\n";
            $sql .= "    $shop_id,\n";
            $sql .= "    '$accept'";
            $sql .= ");\n"; 

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //登録した構成品の商品IDを抽出 
            $sql  = "SELECT\n";
            $sql .= "   goods_id\n";
            $sql .= " FROM\n";
            $sql .= "   t_goods\n";
            $sql .= " WHERE\n";
            $sql .= "   goods_cd = '$goods_cd'\n";
            $sql .= "   AND\n";
            $sql .= "   shop_id = $shop_id\n";
            $sql .= ";\n";

            $result = Db_Query($conn, $sql);
            $goods_id = pg_fetch_result($result, 0, 0);

            //構成品と部品を構成品マスタに登録
            for($i = 0; $i < count($parts_goods_cd); $i++){
                $sql  = "INSERT INTO t_compose (\n";
                $sql .= "   goods_id,\n";
                $sql .= "   parts_goods_id,\n";
                $sql .= "   count\n";
                $sql .= ")VALUES(\n";
                $sql .= "   $goods_id,\n";
                $sql .= "   (SELECT\n";
                $sql .= "       goods_id\n";
                $sql .= "   FROM\n";
                $sql .= "       t_goods\n";
                $sql .= "   WHERE\n";
                $sql .= "       goods_cd = '$parts_goods_cd[$i]'\n";
                $sql .= "       AND\n";
                $sql .= "       shop_id = $shop_id\n";
                $sql .= "   ),\n";
                $sql .= "   $count[$i]\n";
                $sql .= ");\n";
                $result = Db_Query($conn, $sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK");
                    exit;
                } 
            }
        }

        //登録した情報をログに残す
        $result = Log_Save( $conn, "compose", $work_div,$goods_cd,$goods_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }
        Db_query($conn, "COMMIT;");
        $freeze_flg = true;
    }
//商品検索処理
}elseif($_POST["search_row"] != null){

    $search_row = $_POST["search_row"];
    $goods_cd = $_POST["form_parts_goods_cd"][$search_row];

    $sql  = "SELECT";
    $sql .= "   t_goods.goods_name,\n";
    $sql .= "   t_price.r_price\n";
    $sql .= " FROM\n";
    $sql .= "   t_goods\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price\n";
    $sql .= "   ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_cd = '$goods_cd'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.public_flg = 't'";
    $sql .= "   AND\n";
    $sql .= "   t_goods.accept_flg = '1'";
    $sql .= "   AND\n";
    $sql .= "   t_goods.state = '1'";
    $sql .= "   AND\n";
    $sql .= "   t_goods.compose_flg = 'f'";
    $sql .= "   AND\n";
    $sql .= "   t_goods.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_price.rank_cd = '1'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.no_change_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   t_price.shop_id = $shop_id";
    $sql .= ";\n";

    $result = Db_Query($conn, $sql);
    $goods_name = @pg_fetch_result($result, 0, 0);
    $price      = @pg_fetch_result($result, 0, 1);

    $set_goods_data["form_parts_goods_name"][$search_row] = $goods_name;
    $set_goods_data["form_buy_price"][$search_row] = $price;
    $set_goods_data["form_count"][$search_row] = "";
    $set_goods_data["search_row"] = "";

    $form->setConstants($set_goods_data);
}

/******************************/
//登録後処理
/******************************/
if($freeze_flg == true){

    // 「戻る」ボタンの遷移先ID取得
    // 新規時
    if ($get_goods_id == null){
        $sql    = "SELECT MAX(goods_id) FROM t_goods WHERE shop_id = $shop_id AND compose_flg = 't';";
        $res    = Db_Query($conn, $sql);
        $get_id = pg_fetch_result($res, 0, 0);
    }else{
        $get_id = $get_goods_id;
    }

    $form->addElement("button","form_entry_button","Ｏ　Ｋ","onClick=\"location.href='./1-1-230.php'\" $disabled");
    $form->addElement("button","form_back_button","戻　る", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."?goods_id=$get_id'\"");
    $form->addElement("static","form_goods_link","","構成品コード","");
    $form->freeze();
}else{
	// 入力権限のあるスタッフのみ出力
	$form->addElement("submit","form_entry_button","登　録","onClick=\"javascript:return Dialogue('構成品は一度登録すると変更できません。','#')\" $disabled");
    //次へボタン
    if($next_id != null){
        $form->addElement("button","next_button","次　へ","onClick=\"location.href='./1-1-230.php?goods_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","次　へ","disabled");
    }

    //前へボタン
    if($back_id != null){
        $form->addElement("button","back_button","前　へ","onClick=\"location.href='./1-1-230.php?goods_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","前　へ","disabled");
    }

    $form->addElement(
        "link","form_goods_link","","#","構成品コード",
        "onClick=\"return Open_SubWin('../dialog/2-0-210.php', Array('form_compose_goods[cd]', 'form_compose_goods[name]'), 500, 450);\""
     );

}

/*****************************/
//フォーム作成（変動）
/*****************************/
//行番号カウンタ
$row_num = 1;

if($freeze_flg == true || $update_flg == true){
    $style  = "color : #000000;";
    $style .= "border : #ffffff 1px solid;";
    $style .= "background-color: #ffffff;";
    $g_form_option = "readonly";
}

for($i = 0; $i < $max_row; $i++){    //削除行判定
    if(!in_array("$i", $del_history)){
        //削除履歴
        $del_data = $delete_row.",".$i;

        /***************************/
        //動的フォーム作成
        /***************************/ 
        //商品コード
        $form_goods =& $form->addElement(
                "text","form_parts_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
                onChange=\"goods_search_1(this.form, 'form_parts_goods_cd', 'search_row', $i)\" 
                $g_form_option style=\"$style ime-mode: disabled;\"
            ");

        //商品名
        $form_goods =& $form->addElement(
                "text","form_parts_goods_name[$i]","","size=\"34\" style=\"$style\" $g_text_readonly"
            );      

        //仕入単価
        $form_goods =& $form->addElement( 
                "text","form_buy_price[$i]",""," 
                style = \"color: #000000;
                border : #ffffff 1px solid;
                text-align : right;
                background-color : #ffffff;\"
                $g_text_readonly"
            );

        //数量  
        $form->addElement(
                "text","form_count[$i]","","size=\"5\" maxLength=\"5\" style=\"$style ime-mode: disabled; text-align: right\"
                onKeyup=\"buy_money('$i')\"
                $g_form_option"
            );      

        //仕入金額
        $form_goods =& $form->addElement( 
                "text","form_buy_money[$i]","","
                style = \"color: #000000;
                border : #ffffff 1px solid;
                text-align : right;
                background-color : #ffffff;\"
                $g_text_readonly"
            );


        /****************************/
        //表示用HTML作成
        /****************************/
        $html .= "<tr class=\"Result1\">\n";
        $html .=    "<td align=\"right\">$row_num</td>\n";

        //商品コード・商品名
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_parts_goods_cd[$i]"]]->toHtml();
        if($freeze_flg != true && $update_flg != true){
            $html .=    "（<a href=\"#\" onClick=\"return Open_SubWin('../dialog/1-0-210.php', 
                Array('form_parts_goods_cd[$i]', 'search_row'), 500, 450,5,$shop_id,$i);\">検索</a>）";
        }
        $html .=    "</td>\n";
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_parts_goods_name[$i]"]]->toHtml();
        $html .=    "</td>\n";
       //仕入単価 
        $html .=    "<td>\n";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_price[$i]"]]->toHtml();
        $html .=    "</td>\n";

        //数量（分子/分母）
        $html .=    "<td align=\"center\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_count[$i]"]]->toHtml();
        $html .=    "</td>\n";

        //仕入金額
        $html .=    "<td>\n";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_money[$i]"]]->toHtml();
        $html .=    "</td>\n";

        if($freeze_flg != true && $update_flg != true){
            $html .=    "<td align=\"center\">";
            $html .=       "<a href=\"#\" onClick=\"javascript:Dialogue_1('削除します。',  '$del_data', 'delete_row')\">削除</a>";
            $html .=    "</td>\n";
        }
        $html .= "</tr>\n";

        //行番号を＋
        $row_num = $row_num+1;
    }
}

/****************************/
//javascript
/****************************/
$js  = "function buy_money(num){\n";
$js .= "   //フォーム名定義\n";
$js .= "    var BP = \"form_buy_price\"+\"[\"+num+\"]\";\n";
$js .= "    var BM = \"form_buy_money\"+\"[\"+num+\"]\";\n";
$js .= "    var CO = \"form_count\"+\"[\"+num+\"]\";\n";

$js .= "    //VALUE \n";
$js .= "    var BPV = document.dateForm.elements[BP].value;\n";
$js .= "    var COV = document.dateForm.elements[CO].value;\n";

$js .= "    //カンマを取り除く\n";
$js .= "    var BPV = BPV.replace(\",\",\"\");\n";
$js .= "    var BPV = BPV.replace(\",\",\"\");\n";

$js .= "    //計算\n";
$js .= "    if(isNaN(COV) == false && COV != \"\" && BPV != \"\"){ \n";
$js .= "        var COV = eval(COV * 1000) \n";
$js .= "        var BMV = eval(BPV * COV)/1000;\n";
$js .= "        var BMV = String(myFormatNumber(BMV));\n";

$js .= "        var AB = BMV.split(\".\");\n";
$js .= "        if(AB[1] == undefined){\n";
$js .= "            AB[1] = \"00\"; \n";
$js .= "        }\n";

$js .= "        document.dateForm.elements[BM].value = AB[0]+\".\"+AB[1];\n";
$js .= "    }else{\n";
$js .= "        document.dateForm.elements[BM].value = \"\";\n";
$js .= "    }\n";
$js .= "}\n";

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

/****************************/
//全件数取得
/****************************/
$compose_goods_sql  = " SELECT";
$compose_goods_sql .= "    COUNT(t_goods_id.goods_id)";
$compose_goods_sql .= " FROM";
$compose_goods_sql .= "    (SELECT ";
$compose_goods_sql .= "    DISTINCT";
$compose_goods_sql .= "    t_compose.goods_id ";
$compose_goods_sql .= "    FROM ";
$compose_goods_sql .= "    t_compose";
$compose_goods_sql .= "    ) AS t_goods_id";
//ヘッダーに表示させる全件数
$total_count_sql = $compose_goods_sql.";";
$result = Db_Query($conn, $total_count_sql);
$total_count = @pg_fetch_result($result,0,0);

$page_title .= "　（全".$total_count."件）";
$page_title .= "　　　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
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
    'freeze_flg'                => "$freeze_flg",
    'auth_r_msg'                => "$auth_r_msg",
    'js'                        => "$js"
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
