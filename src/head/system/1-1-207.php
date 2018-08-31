<?php
/*
 * 変更履歴 revision history
 * 1.0.0 (2006/03/20) 呼出コードの重複チェック修正(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp> Please put your name here
 *
 * @version		1.1.0 (2006/03/20)
*/

/*
 * 履歴 history：
 *  日付 date            B票No. B slip      担当者assignee      内容detail
 *  -----------------------------------------------------------
 *  2007-01-23      仕様変更　　watanabe-k　ボタンの色を変更
 *  2010-04-28      Rev.1.5　　 hashimoto-y 非表示機能の追加
 *   2016/01/20                amano  Dialogue, Button_Submit 関数でボタン名が送られない IE11 バグ対応
*/




$page_title = "銀行マスタ";

//環境設定ファイル Environment setting file
require_once("ENV_local.php");

//HTML_QuickFormを作成 Create HTML_QuickForm
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続 Connect to DataBase 
$db_con = Db_Connect();

// 権限チェック Checking of Authority
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ Message for no authorization to Input・Change
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled button disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得 acquire outside variable
/****************************/
$shop_id  = $_SESSION[client_id];

/* GETしたIDの正当性チェック check the gotten ID's legitimacy */ 
if ($_GET["bank_id"] != null && Get_Id_Check_Db($db_con, $_GET["bank_id"], "bank_id", "t_bank", "num", " shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/****************************/
//部品定義 defined components
/****************************/
//銀行コード bank code
$form->addElement("text","form_bank_cd","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
//銀行名 bank name
$form->addElement("text","form_bank_name","テキストフォーム","size=\"34\" maxLength=\"15\"".$g_form_option."\"");
//銀行名（フリガナ） bank name (how to spell it in katakana)
$form->addElement("text","form_bank_kana","テキストフォーム","size=\"34\" maxLength=\"15\"".$g_form_option."\"");
//略称 abbreviation
$form->addElement("text","form_bank_cname","テキストフォーム","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

#2010-04-22 hashimoto-y
$form->addElement('checkbox', 'form_nondisp_flg', '', '');

//備考 remarks
$form->addElement("text","form_note","テキストフォーム","size=\"34\" maxLength=\"30\"".$g_form_option."\"");
//クリア clear
$form->addElement("button","clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
//登録 register
$form->addElement("submit","entry_button","登　録","onClick=\"javascript:return Dialogue('登録します。','#', this)\" $disabled");
//CSV出力 csv output
$form->addElement("button","csv_button","CSV出力","onClick=\"javascript:Button_Submit('csv_button_flg','#','true', this)\"");

$form->addElement("button","bank_button","銀行登録画面",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","bank_mine_button","支店登録画面","onClick=\"javascript:Referer('1-1-208.php')\"");
$form->addElement("button","bank_account_button","口座登録画面","onClick=\"javascript:Referer('1-1-210.php')\"");

//更新リンク押下判定フラグ Decision flag when the update link is pressed
$form->addElement("hidden", "update_flg");
//CSV出力ボタン押下判定フラグ Decision flag when the csv output button is pressed
$form->addElement("hidden", "csv_button_flg");

/******************************/
//CSV出力ボタン押下処理 Process when the csv output button is clicked 
/*****************************/
if($_POST["csv_button_flg"]==true && $_POST["entry_button"] != "登　録" && $_POST["input_button_flg"]!=true){
    /** CSV作成SQL Create csv SQL**/
    $sql = "SELECT ";
    $sql .= "   bank_cd,";             //銀行コード bank code
    $sql .= "   bank_name,";           //銀行名 bank name
    $sql .= "   bank_kana, ";          //銀行名（フリガナ）bank name (pronunciation in katakana)
    $sql .= "   bank_cname,";          //略称 abbreviation
    #2010-04-28 hashimoto-y
    $sql .= "   CASE nondisp_flg";     //非表示 do not display
    $sql .= "   WHEN true  THEN '○'";          
    $sql .= "   WHEN false THEN ''";          
    $sql .= "   END,";          

    $sql .= "   note ";                //備考 remarks
    $sql .= " FROM ";
    $sql .= "   t_bank ";
    $sql .= " WHERE ";
    $sql .= "   shop_id = $shop_id ";
    $sql .= "   ORDER BY "
    $sql .= "   bank_cd;";

    $result = Db_Query($db_con,$sql);

    //CSVデータ取得 acquire csv data
    $i=0;
    while($data_list = pg_fetch_array($result)){
        //銀行コード bank code
        $bank_data[$i][0] = $data_list[0];
        //銀行名 bank name
        $bank_data[$i][1] = $data_list[1];
        //銀行名（フリガナ） bank name (pronunciation with katakana)
        $bank_data[$i][2] = $data_list[2];
        //略称 abbreviation
        $bank_data[$i][3] = $data_list[3];

        #2010-04-28 hashimoto-y
        #//備考 remarks
        #$bank_data[$i][4] = $data_list[4];
        //非表示 do not display
        $bank_data[$i][4] = $data_list[4];
        //備考 remarks
        $bank_data[$i][5] = $data_list[5];
        $i++;
    }

    //CSVファイル名 csv file name
    $csv_file_name = "銀行マスタ".date("Ymd").".csv";
    //CSVヘッダ作成 create csv header
    $csv_header = array(
        "銀行コード", 
        "銀行名",
        "銀行名（フリガナ）",
        "略称",
        #2010-04-28 hashimoto-y
        "非表示",
        "備考"
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($bank_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/****************************/
//変更処理（リンク）change/revision process (link)
/****************************/

//変更リンク押下判定 decision when the change/revise link is pressed
if($_GET["bank_id"] != ""){

    //変更するレンタルIDを取得 acquire the rental ID that will be changed
    $update_num = $_GET["bank_id"];

    /** 銀行マスタ取得SQL作成 create the SQL that will acquire the bank master **/
    $sql = "SELECT ";
    $sql .= "bank_cd,";             //銀行コード bank code
    $sql .= "bank_name,";           //銀行名 bank name
    $sql .= "bank_kana,";           //銀行名（フリガナ）bank name (pronunciation with katakana)
    $sql .= "bank_cname,";          //略称 abbreviation
    #2010-04-28 hashimoto-y
    $sql .= "nondisp_flg,";         //非表示 do not display
    $sql .= "note ";                //備考 remarks
    $sql .= "FROM ";
    $sql .= "t_bank ";
    $sql .= "WHERE ";
    $sql .= "shop_id = $shop_id ";
	$sql .= "AND ";
    $sql .= "bank_id = ".$update_num.";";
    $result = Db_Query($db_con,$sql);
    //GETデータ判定
    Get_Id_Check($result);
    $data_list = pg_fetch_array($result,0);

    //フォームに値を復元 restore the value to form
    $def_fdata["form_bank_cd"]                        =    $data_list[0];  
    $def_fdata["form_bank_name"]                      =    $data_list[1];  
    $def_fdata["form_bank_kana"]                      =    $data_list[2];  
    $def_fdata["form_bank_cname"]                     =    $data_list[3];  
    #2010-04-28 hashimoto-y
    #$def_fdata["form_note"]                           =    $data_list[4]; 
    $def_fdata["form_nondisp_flg"]                    =    ($data_list[4] == 't')? 1 : 0; 
    $def_fdata["form_note"]                           =    $data_list[5]; 
    $def_fdata["update_flg"]                          =    "true"; 

    $form->setDefaults($def_fdata);
}

/****************************/
//エラーチェック(AddRule) error check (AddRule)
/****************************/
//◇銀行コード bank code
//・必須チェック required field 
$form->addRule('form_bank_cd','銀行コードは半角数字のみ4桁です。','required');
$form->addRule('form_bank_cd','銀行コードは半角数字のみ4桁です。', "regex", "/^[0-9]+$/");

//◇銀行名 bank name
//・必須チェック required field
$form->addRule('form_bank_name','銀行名 は1文字以上15文字以下です。','required');
// 全角/半角スペースのみチェック check if bank name only has full-width/half-width space 
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_bank_name", "銀行名 にスペースのみの登録はできません。", "no_sp_name");

//◇銀行名（フリガナ）bank name (pronunciation with katakana)
//・必須チェック required field
$form->addRule('form_bank_kana','銀行名（フリガナ） は1文字以上15文字以下です。','required');

//◇略称 abbreviation
//・必須チェック required field
$form->addRule('form_bank_cname','略称 は1文字以上10文字以下です。','required');

/****************************/
//登録処理 change/revise process
/****************************/
if($_POST["entry_button"] == "登　録"){
    //入力フォーム値取得 acquire the input form value
    $bank_cd      = $_POST["form_bank_cd"];                 //銀行コード bank code
    $bank_name    = $_POST["form_bank_name"];               //銀行名 bank name
    $bank_kana    = $_POST["form_bank_kana"];               //銀行名（フリガナ） bank name (pronunciation in katakana)
    $bank_cname   = $_POST["form_bank_cname"];              //略称 abbreviation
    #2010-04-28 hashimoto-y
    $nondisp_flg  = ($_POST["form_nondisp_flg"] == '1')? 't' : 'f';             //非表示 do not display
    $note         = $_POST["form_note"];                    //備考 remarks
    $update_flg   = $_POST["update_flg"];                   //登録・更新判定 change・update decision 
    $update_num   = $_GET["bank_id"];                       //銀行ID bankID


    /****************************/
    //エラーチェック(PHP) Error check (PHP)
    /****************************/
    //◇呼出コード call code
    //・重複チェック check duplication
    if($bank_cd != null){
        //呼出コードに０を埋める fill 0 in the call code
        $bank_cd = str_pad($bank_cd, 4, 0, STR_POS_LEFT);
        //入力したコードがマスタに存在するかチェック check if the inputted code exists in the master
        $sql  = "SELECT ";
        $sql .= "   bank_cd ";                //呼出コード call code
        $sql .= "FROM ";
        $sql .= "   t_bank ";
        $sql .= "WHERE ";
        $sql .= "   bank_cd = '$bank_cd' ";
        $sql .= "   AND ";
        $sql .= "   shop_id = $shop_id";

        //変更の場合は、自分のデータ以外を参照する if revision will happen then refer to the data other than yours
        if($update_num != null && $update_flg == "true"){
            $sql .= " AND NOT ";
            $sql .= "bank_id = '$update_num'";
        }
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form->setElementError("form_bank_cd","既に使用されている 銀行コード です。");
        }
    }

    //■銀行名（フリガナ） bank name (pronunciation with katakana)
    //・特定の文字だけ使用可能 allow only certain character to be used
    if (!mb_ereg("^[0-9A-Zｱ-ﾝﾞﾟｰ･ ]+$", $bank_kana)){
        $form->setElementError("form_bank_kana", "銀行名（フリガナ） は、半角ｶﾅ（大文字）と半角英数字（大文字）のみ使用可能です。");
    }


    //エラーの際には、登録処理を行わない do not process registration if in case of error
    if($form->validate()){
        
        Db_Query($db_con, "BEGIN;");

        //更新か登録か判定 judge if it's an update or a registration
        if($update_flg == "true"){
            //作業区分は更新 update the production classification
            $work_div = '2';
            //変更完了メッセージ message for completion of the revision/change
            $comp_msg = "変更しました。";

            $sql  = "UPDATE ";
            $sql .= "t_bank ";
            $sql .= "SET ";
            $sql .= "bank_cd = '$bank_cd',";
            $sql .= "bank_name = '$bank_name',";
            $sql .= "bank_kana = '$bank_kana',";
            $sql .= "bank_cname = '$bank_cname',";
            #2010-04-28 hashimoto-y
            $sql .= "nondisp_flg = '$nondisp_flg',";
            $sql .= "note = '$note' ";
            $sql .= "WHERE ";
            $sql .= "bank_id = $update_num;";
        }else{
            //作業区分は登録 register the production classification
            $work_div = '1';
            //登録完了メッセージ message for completion of the revision/change
            $comp_msg = "登録しました。";

            $sql  = "INSERT INTO t_bank (";
            $sql .= "   bank_id,";
            $sql .= "   bank_cd,";
            $sql .= "   bank_name,";
            $sql .= "   bank_kana,";
            $sql .= "   bank_cname,";
            #2010-04-28 hashimoto-y
            $sql .= "   nondisp_flg,";
            $sql .= "   note,";
            $sql .= "   shop_id";
            $sql .= " )VALUES(";
            $sql .= " (SELECT COALESCE(MAX(bank_id), 0)+1 FROM t_bank),";
            $sql .= "'$bank_cd',";
            $sql .= "'$bank_name',";
            $sql .= "'$bank_kana',";
            $sql .= "'$bank_cname',";
            #2010-04-28 hashimoto-y
            $sql .= "'$nondisp_flg',";
            $sql .= "'$note',";
            $sql .= "$shop_id);";
        }
        $result = Db_Query($db_con,$sql);
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        //銀行マスタの値をログに書き込む write the value of the bank master in the log
        $result = Log_Save($db_con,'bank',$work_div,$bank_cd,$bank_name);
        //ログ登録時にエラーになった場合 if error occurs during log registration
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        Db_Query($db_con, "COMMIT;");

        //フォームの値を初期化 initialize the value of the form
        $def_fdata["form_bank_cd"]                        =    "";
        $def_fdata["form_bank_name"]                      =    "";
        $def_fdata["form_bank_kana"]                      =    "";
        $def_fdata["form_bank_cname"]                     =    "";
        #2010-04-28 hashimoto-y
        $def_fdata["form_nondisp_flg"]                    =    "";
        $def_fdata["form_note"]                           =    "";
        $def_fdata["update_flg"]                          =    "";

        $form->setConstants($def_fdata);
    }
}

/******************************/
//ヘッダーに表示させる全件数 number of all items that will be displayed in the header
/*****************************/
/** 銀行マスタ取得SQL作成 Create the SQL that will acquire the bank master**/
$sql  = "SELECT ";
$sql .= "   bank_id,";                //銀行ID bank ID
$sql .= "   bank_cd,";                //銀行コード bank code
$sql .= "   bank_name,";              //銀行名 bank name
$sql .= "   bank_kana,";              //銀行名（フリガナ）bank name (pronunciation with katakana)
$sql .= "   bank_cname,";             //略称 abbreviation
#2010-04-28 hashimoto-y
$sql .= "   CASE nondisp_flg";     //非表示 do not display
$sql .= "   WHEN true  THEN '○'";          
$sql .= "   WHEN false THEN ''";          
$sql .= "   END,";          

$sql .= "   note";
$sql .= " FROM ";
$sql .= "   t_bank ";
$sql .= " WHERE ";
$sql .= "   shop_id = $shop_id ";
$sql .= " ORDER BY bank_cd;";

$result = Db_Query($db_con,$sql);
//全件数取得(ヘッダー) number of all items acquired (header(
$total_count = pg_num_rows($result);

//行データ部品を作成 create the row data components
$row = Get_Data($result);

/****************************/
//HTMLヘッダ HTML header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ HTML footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 Create menu
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成 create screen header
/****************************/
$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[bank_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[bank_mine_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[bank_account_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定 setting related to Render
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign form related variables
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assign other variables
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'total_count'   => "$total_count",
    'comp_msg'      => "$comp_msg",
    'auth_r_msg'    => "$auth_r_msg",
));
$smarty->assign('row',$row);
//テンプレートへ値を渡す pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
