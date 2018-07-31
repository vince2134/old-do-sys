<?php
/************************************
// 変更履歴
//  (04/20)
//  住所３、直送先２の登録処理追加(watanabe-k)
//  (08/22)
//  アップデート時にshop_idの条件を削除（watanabe-k）
/***********************************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/25　0103　　　　 watanabe-k　 GETチェック追加
 * 　2006/11/25　0102　　　　 watanabe-k　 直送先名に空白チェック追加
*  2015/05/01                  amano  Dialogue関数でボタン名が送られない IE11 バグ対応
 */


$page_title = "直送先マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$direct_id     = $_GET["direct_id"];
//$direct_permit = $_SESSION["direct_permit"]; //直送先

/****************************/
//デフォルト値設定
/****************************/
//登録・変更判定
if($direct_id != null){

    Get_Id_Check3($direct_id);

    /** 変更データ取得SQL **/
    $sql = "SELECT ";
    $sql .= "direct_cd,";                //直送先コード
    $sql .= "direct_name,";              //直送先名
    $sql .= "direct_cname,";             //略称
    $sql .= "t_direct.post_no1,";        //郵便番号1
    $sql .= "t_direct.post_no2,";        //郵便番号2
    $sql .= "t_direct.address1,";        //住所1
    $sql .= "t_direct.address2,";        //住所2
    $sql .= "t_direct.address3,";        //住所3
    $sql .= "t_direct.tel,";             //TEL
    $sql .= "t_direct.fax,";             //FAX
    $sql .= "t_direct.note,";            //備考
    $sql .= "t_client.client_cd1,";      //得意先CD
    $sql .= "t_client.client_cd2,";      //支店CD
    $sql .= "t_client.client_name,";     //請求先名
    $sql .= "direct_name2 ";             //直送先名２
    $sql .= "FROM ";
    $sql .= "t_direct ";
    $sql .= "LEFT JOIN ";
    $sql .= "t_client ";
    $sql .= "ON ";
    $sql .= "t_direct.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " t_direct.shop_id IN (".Rank_Sql().") " : " t_direct.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "t_direct.direct_id = $direct_id;";
    
    $result = Db_Query($db_con,$sql);
    //GETデータ判定
    Get_Id_Check($result);
    $data_list = pg_fetch_array($result,0);

    //フォームに値を復元
    $def_fdata["form_direct_cd"]                      =    $data_list[0];     //直送先コード
    $def_fdata["form_direct_name"]                    =    $data_list[1];     //直送先名
    $def_fdata["form_direct_name2"]                   =    $data_list[14];    //直送先名2
    $def_fdata["form_direct_cname"]                   =    $data_list[2];     //略称
    $def_fdata["form_post"]["form_post_no1"]          =    $data_list[3];     //郵便番号1
    $def_fdata["form_post"]["form_post_no2"]          =    $data_list[4];     //郵便番号2
    $def_fdata["form_address1"]                       =    $data_list[5];     //住所1
    $def_fdata["form_address2"]                       =    $data_list[6];     //住所2
    $def_fdata["form_address3"]                       =    $data_list[7];     //住所3
    $def_fdata["form_tel"]                            =    $data_list[8];     //TEL
    $def_fdata["form_fax"]                            =    $data_list[9];     //FAX
    $def_fdata["form_note"]                           =    $data_list[10];     //備考
    $def_fdata["form_client"]["form_client_cd1"]      =    $data_list[11];    //得意先CD
    $def_fdata["form_client"]["form_client_cd2"]      =    $data_list[12];    //支店CD
    $def_fdata["form_client"]["form_client_name"]     =    $data_list[13];    //請求先名

    $form->setDefaults($def_fdata);
    $id_data = Make_Get_Id($db_con, "direct", $data_list[0]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

}
/****************************/
//部品定義
/****************************/
//直送先コード
$form->addElement("text","form_direct_cd","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
//直送先名
$form->addElement("text","form_direct_name","テキストフォーム","size=\"44\" maxLength=\"25\"".$g_form_option."\"");
//直送先名2
$form->addElement("text","form_direct_name2","テキストフォーム","size=\"44\" maxLength=\"25\"".$g_form_option."\"");
//略称
$form->addElement("text","form_direct_cname","テキストフォーム","size=\"44\" maxLength=\"20\"".$g_form_option."\"");

//郵便番号
$text[] =& $form->createElement("text","form_post_no1","テキストフォーム","size=\"3\" maxLength=\"3\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_post[form_post_no1]','form_post[form_post_no2]',3)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","form_post_no2","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
$form->addGroup( $text, "form_post", "form_post");

//住所１
$form->addElement("text","form_address1","テキストフォーム","size=\"44\" maxLength=\"25\"".$g_form_option."\"");
//住所２
$form->addElement("text","form_address2","テキストフォーム","size=\"44\" maxLength=\"25\"".$g_form_option."\"");
//住所3
$form->addElement("text","form_address3","テキストフォーム","size=\"44\" maxLength=\"30\"".$g_form_option."\"");
//TEL
$form->addElement("text","form_tel","テキストフォーム","size=\"44\" maxLength=\"30\" style=\"$g_form_style\"".$g_form_option."\"");
//FAX
$form->addElement("text","form_fax","テキストフォーム","size=\"44\" maxLength=\"30\" style=\"$g_form_style\" ".$g_form_option."\"");

//請求先
$text = "";
$text[] =& $form->createElement("text","form_client_cd1","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onKeyUp=\"javascript:client1('form_client[form_client_cd1]','form_client[form_client_cd2]','form_client[form_client_name]');changeText(this.form,'form_client[form_client_cd1]','form_client[form_client_cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","form_client_cd2","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onKeyUp=\"javascript:client1('form_client[form_client_cd1]','form_client[form_client_cd2]','form_client[form_client_name]')\"".$g_form_option."\"");
$text[] =& $form->createElement("text","form_client_name","テキストフォーム","size=\"34\"$g_text_readonly");
$form->addGroup( $text, "form_client", "form_client");

//備考
$form->addElement("text","form_note","テキストフォーム","size=\"34\" maxLength=\"30\"".$g_form_option."\"");

//削除権限があるか
//削除ボタン
//$form->addElement("button","del_button","削　除","style=\"color: #ff0000;\" onClick=\"javascript:Dialogue_2('削除します。', '#', 'true', 'del_button_flg')\" $disabled");
//$form->addElement("hidden","del_button_flg","","");

//if($direct_permit != 'n' && $direct_permit != ''){
	//変更・一覧
	$form->addElement("button","change_button","変更・一覧","onClick=\"javascript:Referer('2-1-218.php')\"");
	//登録(ヘッダ)
	$form->addElement("button","new_button","登録画面",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//}
//請求先マスタ取得
$code_value .= Code_Value("t_client",$db_con,"",1);

//自動入力ボタン押下判定フラグ
$form->addElement("hidden", "input_button_flg");

/****************************/
//エラーチェック(AddRule)
/****************************/

//◇直送先コード
//・必須チェック
$form->addRule('form_direct_cd','直送先コードは半角数字のみです。','required');
//・文字種チェック
$form->addRule('form_direct_cd','直送先コードは半角数字のみです。',"regex", "/^[0-9]+$/");

//◇直送先名
//・必須チェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule('form_direct_name','直送先名は1文字以上15文字以下です。','required');
$form->addRule('form_direct_name','直送先名にスペースのみの登録はできません。','no_sp_name');

//◇略称
//・必須チェック
$form->addRule('form_direct_cname','略称は1文字以上10文字以下です。','required');

//◇郵便番号
//・必須チェック
//・文字数チェック
//・文字種チェック
$form->addGroupRule('form_post', array(
    'form_post_no1' => array(
        array('郵便番号は半角数字の7桁です。','required'),
        array('郵便番号は半角数字の7桁です。','rangelength',array(3,3)),
        array('郵便番号は半角数字の7桁です。',"regex", "/^[0-9]+$/")
    ),
    'form_post_no2' => array(
        array('郵便番号は半角数字の7桁です。','required'),
        array('郵便番号は半角数字の7桁です。','rangelength',array(4,4)),
        array('郵便番号は半角数字の7桁です。',"regex", "/^[0-9]+$/"),
    )
));

//◇住所1
//・必須チェック
$form->addRule('form_address1','住所１は1文字以上15文字以下です。','required');

//◇TEL
//・文字種チェック
$form->addRule("form_tel", "TELは半角数字と「-」のみ13桁です。", "regex", "/^[0-9-]+$/");

//◇FAX
//・文字種チェック
$form->addRule("form_fax", "FAXは半角数字と「-」のみ13桁です。", "regex", "/^[0-9-]+$/");


/******************************/
//自動入力ボタン押下処理
/*****************************/
if($_POST["input_button_flg"]==true){
    $post1     = $_POST["form_post"]["form_post_no1"];               //郵便番号１
    $post2     = $_POST["form_post"]["form_post_no2"];               //郵便番号２
    //郵便番号から値取得
    $post_value = Post_Get($post1,$post2,$db_con);
    $cons_data["form_post"]["form_post_no1"]     = $post1;
    $cons_data["form_post"]["form_post_no2"]     = $post2;
    $cons_data["form_address1"]                  = $post_value[1];   //住所1
    $cons_data["form_address2"]                  = $post_value[2];   //住所2
    //郵便番号フラグをクリア
    $cons_data["input_button_flg"]               = "";
    $form->setConstants($cons_data);
}

/******************************/
//登録ボタン押下処理
/*****************************/
if($_POST["entry_button"] == "登　録"){
    $direct_cd         = $_POST["form_direct_cd"];                 //直送先コード
    $direct_name     = $_POST["form_direct_name"];                 //直送先名
    $direct_cname     = $_POST["form_direct_cname"];               //略称
    $post1             = $_POST["form_post"]["form_post_no1"];     //郵便番号1
    $post2             = $_POST["form_post"]["form_post_no2"];     //郵便番号2
    $add1             = $_POST["form_address1"];                   //住所1
    $add2             = $_POST["form_address2"];                   //住所2
    $add3             = $_POST["form_address3"];                   //住所3
    $tel             = $_POST["form_tel"];                         //TEL
    $fax             = $_POST["form_fax"];                         //FAX
    $note             = $_POST["form_note"];                       //備考
    $client_cd1     = $_POST["form_client"]["form_client_cd1"];    //得意先CD
    $client_cd2     = $_POST["form_client"]["form_client_cd2"];    //支店CD
    $client_name     = $_POST["form_client"]["form_client_name"];  //請求先名
    $direct_name2     = $_POST["form_direct_name2"];                 //直送先名

    /****************************/
    //エラーチェック(PHP)
    /****************************/
    //エラー判別フラグ
    $err_flg = false;

    //◇直送先コード
    //・重複チェック
    if($direct_cd != null){
        //直送先コードに０を埋める
        $direct_cd = str_pad($direct_cd, 4, 0, STR_POS_LEFT);
        //入力したコードがマスタに存在するかチェック
        $sql  = "SELECT ";
        $sql .= "direct_cd ";                //直送先コード
        $sql .= "FROM ";
        $sql .= "t_direct ";
        $sql .= "WHERE ";
        $sql .= "direct_cd = '$direct_cd' ";
        $sql .= "AND ";
        $sql .= ($group_kind == "2") ? " t_direct.shop_id IN (".Rank_Sql().") " : " t_direct.shop_id = $shop_id ";

        //変更の場合は、自分のデータ以外を参照する
        if($direct_id != null){
            $sql .= " AND NOT ";
            $sql .= "direct_id = '$direct_id'";
        }
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form_direct_cd_error = "既に使用されている 直送先コード です。";
              $err_flg = true;
        }
    }

    //◇請求先
    //・入力値チェック
    if(($client_cd1 != null && $client_name == null) || ($client_cd2 != null && $client_name == null) || ($client_cd1 != null && $client_cd2 != null && $client_name == null)){
        $form_client_error = "正しい請求先コードを入力して下さい。";
          $err_flg = true;
    }

    //エラーの際には、登録・変更処理を行わない
    if($form->validate() && $err_flg == false){
        Db_Query($db_con, "BEGIN;");
 
        //登録・変更判定
        if($direct_id != null){
            //作業区分は更新
            $work_div = '2';

            $sql  = "UPDATE ";
            $sql .= "t_direct ";
            $sql .= "SET ";
            $sql .= "direct_cd = '$direct_cd',";
            $sql .= "direct_name = '$direct_name',";
            $sql .= "direct_name2 = '$direct_name2',";
            $sql .= "direct_cname = '$direct_cname',";
            $sql .= "post_no1 = '$post1',";
            $sql .= "post_no2 = '$post2',";
            $sql .= "address1 = '$add1',";
            $sql .= "address2 = '$add2',";
            $sql .= "address3 = '$add3',";
            $sql .= "tel = '$tel',";
            $sql .= "fax = '$fax',";
            $sql .= "note = '$note',";
            //請求先の入力判定
            if($client_cd1 != null && $client_cd2 != null){
                $sql .= "client_id = ";
                $sql .= "(SELECT ";
                $sql .= "client_id ";
                $sql .= "FROM ";
                $sql .= "t_client ";
                $sql .= "WHERE ";
			    $sql .= "shop_id = $shop_id ";
	            $sql .= "AND ";
	            $sql .= "client_div = '1' ";
			    $sql .= "AND ";
                $sql .= "client_cd1 = '$client_cd1' ";
                $sql .= "AND ";
                $sql .= "client_cd2 = '$client_cd2') ";
            }else{
                $sql .= "client_id = null ";
            }
            $sql .= "WHERE ";
//            $sql .= "t_direct.shop_id = $shop_id ";
//            $sql .= "AND ";
            $sql .= "t_direct.direct_id = $direct_id;";
        }else{
            //作業区分は登録
            $work_div = '1';

            $sql  = "INSERT INTO t_direct (";
            $sql .= "   direct_id,";            //直送先ID
            $sql .= "   direct_cd,";            //直送先CD
            $sql .= "   direct_name,";          //直送先名
            $sql .= "   direct_name2,";         //直送先名２
            $sql .= "   direct_cname,";         //略称
            $sql .= "   post_no1,";             //郵便番号１
            $sql .= "   post_no2,";             //郵便番号２
            $sql .= "   address1,";             //住所１
            $sql .= "   address2,";             //住所２
            $sql .= "   address3,";             //住所３
            $sql .= "   tel,";                  //電話番号
            $sql .= "   fax,";                  //FAX
            $sql .= "   note,";                 //備考
            $sql .= "   client_id,";            //請求先ID
            $sql .= "   shop_id";               //FCグループID
            $sql .= " )VALUES(";
            $sql .= "   (SELECT COALESCE(MAX(direct_id), 0)+1 FROM t_direct),";     //直送先ID
            $sql .= "'$direct_cd',";            //直送先CD
            $sql .= "'$direct_name',";          //直送先名
            $sql .= "'$direct_name2',";         //直送先名２
            $sql .= "'$direct_cname',";         //略称
            $sql .= "'$post1',";                //郵便番号１
            $sql .= "'$post2',";                //郵便番号２
            $sql .= "'$add1',";                 //住所１
            $sql .= "'$add2',";                 //住所２
            $sql .= "'$add3',";                 //住所３
            $sql .= "'$tel',";                  //電話番号
            $sql .= "'$fax',";                  //FAX
            $sql .= "'$note',";                 //備考
            //請求先の入力判定
            if($client_cd1 != null && $client_cd2 != null){
                $sql .= "(SELECT ";
                $sql .= "client_id ";
                $sql .= "FROM ";
                $sql .= "t_client ";
                $sql .= "WHERE ";
                $sql .= "shop_id = $shop_id ";
                $sql .= "AND ";
                $sql .= "client_div = '1' ";
                $sql .= "AND ";
                $sql .= "client_cd1 = '$client_cd1' ";
                $sql .= "AND ";
                $sql .= "client_cd2 = '$client_cd2'),";
            }else{
                $sql .= "null,";
            }
            $sql .= "$shop_id";
            $sql .= ");";
        }
        $result = Db_Query($db_con,$sql);
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        //直送先マスタの値をログに書き込む
        $result = Log_Save($db_con,'direct',$work_div,$direct_cd,$direct_name);
        //ログ登録時にエラーになった場合
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        Db_Query($db_con, "COMMIT;");
        $freeze_flg = true;
    }
}

/************************************/
//削除ボタン押下処理
/***********************************/
/*
if($_POST["del_button_flg"] == true){
    Db_Query($db_con, "BEGIN");
    $sql  = "DELETE FROM t_direct";
    $sql .= " WHERE direct_id = $direct_id ;";
    $result = Db_Query($db_con, $sql);

    if($result === false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    }

    Db_Query($db_con, "COMMIT");
    header("Location: 2-1-218.php");
}
*/
//登録確認画面の場合は、以下のボタンを非表示
if($freeze_flg != true){
	//次へボタン
	if($next_id != null){
	    $form->addElement("button","next_button","次　へ","onClick=\"location.href='./2-1-219.php?direct_id=$next_id'\"");
	}else{
	    $form->addElement("button","next_button","次　へ","disabled");
	}
	//前へボタン
	if($back_id != null){
	    $form->addElement("button","back_button","前　へ","onClick=\"location.href='./2-1-219.php?direct_id=$back_id'\"");
	}else{
	    $form->addElement("button","back_button","前　へ","disabled");
	}
    $form->addElement(
            "submit","entry_button","登　録",
            "onClick=\"javascript:return Dialogue('登録します。','#', this)\" $disabled"
    );

	//自動入力
	$form->addElement("button","input_button","自動入力","onClick=\"javascript:Button_Submit('input_button_flg','#','true')\"");
	//請求先
	$form->addElement("link","form_claim_link","","#","請求先","onClick=\"return Open_SubWin('../dialog/2-0-250.php',Array('form_client[form_client_cd1]','form_client[form_client_cd2]','form_client[form_client_name]'),500,450);\"");

    // 新規登録時には出力しない
    if ($direct_id != null){
        // 戻るボタン
        $form->addElement("button", "return_button", "戻　る", "onClick=\"location.href='./2-1-218.php'\"");
    }

}else{

    // 戻るボタンの遷移先ID取得
    // 新規登録時
    if ($direct_id == null){
        $sql    = "SELECT MAX(direct_id) FROM t_direct WHERE shop_id = $shop_id;\n";
        $res    = Db_Query($db_con, $sql);
        $get_id = pg_fetch_result($res, 0, 0);
    // 変更時
    }else{  
        $get_id = $direct_id;
    }

	//登録確認画面では以下のボタンを表示
	//戻る
	$form->addElement("button","return_button","戻　る","onClick=\"location.href='".$_SERVER["PHP_SELF"]."?direct_id=$get_id'\"");
	//OK
	$form->addElement("button","comp_button","O 　K","onClick=\"location.href='./2-1-219.php'\"");
    $form->addElement("static","form_claim_link","","請求先");
    $form->freeze();
}

/******************************/
//ヘッダーに表示させる全件数
/*****************************/
/** 直送先マスタ取得SQL作成 **/
$sql = "SELECT ";
$sql .= "COUNT(direct_id) ";                //直送先ID
$sql .= "FROM ";
$sql .= "t_direct ";
$sql .= "WHERE ";
$sql .= ($group_kind == "2") ? " t_direct.shop_id IN (".Rank_Sql().") " : " t_direct.shop_id = $shop_id ";
$result = Db_Query($db_con,$sql.";");
//全件数取得(ヘッダー)
$total_count_h = pg_fetch_result($result,0,0);

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
$page_menu = Create_Menu_f('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "(全".$total_count_h."件)";
//if($direct_permit != 'n' && $direct_permit != ''){
	$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
	$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
//}
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'                  => "$html_header",
    'page_menu'                    => "$page_menu",
    'page_header'                  => "$page_header",
    'html_footer'                  => "$html_footer",
    'code_value'                   => "$code_value",
    'form_direct_cd_error'         => "$form_direct_cd_error",
    'form_client_error'            => "$form_client_error",
	'direct_id'                    => "$direct_id",
    "freeze_flg"                    => "$freeze_flg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
