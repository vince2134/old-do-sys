<?php
$page_title = "直送先マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$shop_id  = $_SESSION[client_id];

/****************************/
//デフォルト値設定
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
);
$form->setDefaults($def_fdata);

/****************************/
//部品定義
/****************************/
//出力形式
$radio[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio, "form_output_type", "出力形式");
//直送先コード
$form->addElement("text","form_direct_cd","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
//直送先名
$form->addElement("text","form_direct_name","テキストフォーム","size=\"34\" maxLength=\"15\"".$g_form_option."\"");
//略称
$form->addElement("text","form_direct_cname","テキストフォーム","size=\"22\" maxLength=\"10\"".$g_form_option."\"");
//表示
$form->addElement("submit","show_button","表　示");
//クリア
$form->addElement("button","clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
//変更・一覧
//$form->addElement("button","change_button","変更・一覧","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","変更・一覧",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//一括訂正
$form->addElement("button","new_button","登録画面","onClick=\"location.href='1-1-219.php'\"");

//検索
$form->addElement("submit","form_search_button","検索フォームを表示");
/******************************/
//ヘッダーに表示させる全件数
/*****************************/
/** 直送先マスタ取得SQL作成 **/
$sql = "SELECT ";
$sql .= "direct_id,";                //直送先ID
$sql .= "direct_cd,";                //直送先コード
$sql .= "direct_name,";              //直送先名
$sql .= "direct_cname,";             //略称
$sql .= "t_client.client_name ";     //請求先
$sql .= "FROM ";
$sql .= "t_direct ";
$sql .= "LEFT JOIN ";
$sql .= "t_client ";
$sql .= "ON ";
$sql .= "t_direct.client_id = t_client.client_id ";
$sql .= "WHERE ";
$sql .= "t_direct.shop_id = $shop_id ";

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["show_button"]=="表　示"){
    //出力形式
    $output_type = $_POST["form_output_type"];
    //直送先コード
    $direct_cd   = $_POST["form_direct_cd"];
    //直送先名
    $direct_name = $_POST["form_direct_name"];
    //略称
    $direct_cname = $_POST["form_direct_cname"];
}
    //CSV・画面判定
    if($output_type != 2){
        
        /** 条件指定 **/
        //直送先コード指定の有無
        if($direct_cd != null){
            $sql .= "AND direct_cd LIKE '$direct_cd%' ";
        }
        //直送先名指定の有無
        if($direct_name != null){
            $sql .= "AND direct_name LIKE '%$direct_name%' ";
        }
        //略称指定の有無
        if($direct_cname != null){
            $sql .= "AND direct_cname LIKE '%$direct_cname%' ";
        }

        $sql .= "ORDER BY ";
        $sql .= "direct_cd;";
        $result = Db_Query($db_con,$sql);

        //全件数取得
        $total_count = pg_num_rows($result);
    
    }else{
        /** CSV作成SQL **/
        $sql = "SELECT ";
        $sql .= "direct_cd,";                // 0 直送先コード
        $sql .= "direct_name,";              // 1 直送先名
        $sql .= "direct_name2,";             // 2 直送先名２
        $sql .= "direct_cname,";             // 3 略称
        $sql .= "t_direct.post_no1,";        // 4 郵便番号1
        $sql .= "t_direct.post_no2,";        // 5 郵便番号2
        $sql .= "t_direct.address1,";        // 6 住所1
        $sql .= "t_direct.address2,";        // 7 住所2
        $sql .= "t_direct.address3,";        // 8 住所3
        $sql .= "t_direct.tel,";             // 9 TEL
        $sql .= "t_direct.fax,";             // 10 FAX
        $sql .= "t_direct.note,";            // 11 備考
        $sql .= "t_client.client_cd1,";      // 12 請求先コード１
        $sql .= "t_client.client_cd2,";      // 13 請求先コード２
        $sql .= "t_client.client_name ";     // 14 請求先
        $sql .= "FROM ";
        $sql .= "t_direct ";
        $sql .= "LEFT JOIN ";
        $sql .= "t_client ";
        $sql .= "ON ";
        $sql .= "t_direct.client_id = t_client.client_id ";
        $sql .= "WHERE ";
        $sql .= "t_direct.shop_id = $shop_id ";

        /** 条件指定 **/
        //直送先コード指定の有無
        if($direct_cd != null){
            $sql .= "AND direct_cd LIKE '$direct_cd%' ";
        }
        //直送先名指定の有無
        if($direct_name != null){
            $sql .= "AND direct_name LIKE '%$direct_name%' ";
        }
        //略称指定の有無
        if($direct_cname != null){
            $sql .= "AND direct_cname LIKE '%$direct_cname%' ";
        }
        $sql .= "ORDER BY ";
        $sql .= "direct_cd;";

        $result = Db_Query($db_con,$sql);

        //CSVデータ取得
        $i=0;
        while($data_list = pg_fetch_array($result)){
            //直送先コード
            $direct_data[$i][0] = $data_list[0];
            //直送先名
            $direct_data[$i][1] = $data_list[1];
            //直送先名２
            $direct_data[$i][2] = $data_list[2];
            //略称
            $direct_data[$i][3] = $data_list[3];
            //郵便番号1-郵便番号2(両方or片方が未入力の場合はnull表示)
            if($data_list[4] != null && $data_list[5] != null){
                $direct_data[$i][4] = $data_list[4]."-".$data_list[5];
            }else{
                $direct_data[$i][4] = "";
            }
            //住所
            $direct_data[$i][5] = $data_list[6];    //住所1
            $direct_data[$i][6] = $data_list[7];    //住所2
            $direct_data[$i][7] = $data_list[8];    //住所3
            //TEL
            $direct_data[$i][8] = $data_list[9];
            //FAX
            $direct_data[$i][9] = $data_list[10];
            //請求先コード
            $direct_data[$i][10] = ($data_list[12]!=null)?$data_list[12]."-".$data_list[13]:"";
            //請求先名
            $direct_data[$i][11] = $data_list[14];
            //備考
            $direct_data[$i][12] = $data_list[11];
            $i++;
        }

        //CSVファイル名
        $csv_file_name = "直送先マスタ".date("Ymd").".csv";
        //CSVヘッダ作成
        $csv_header = array(
            "直送先コード", 
            "直送先名1",
            "直送先名2",
            "略称",
            "郵便番号",
            "住所１",
            "住所２",
            "住所３",
            "TEL",
            "FAX",
            "請求先コード",
            "請求先名",
            "備考",
        );
        $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
        $csv_data = Make_Csv($direct_data, $csv_header);
        Header("Content-disposition: attachment; filename=$csv_file_name");
        Header("Content-type: application/octet-stream; name=$csv_file_name");
        print $csv_data;
        exit;

    }
    //行データ部品を作成
    $row = Get_Data($result,$output_type);


/******************************/
//ヘッダーに表示させる全件数
/*****************************/
/** 直送先マスタ取得SQL作成 **/
$sql = "SELECT ";
$sql .= "COUNT(direct_id) ";                //直送先ID
$sql .= "FROM ";
$sql .= "t_direct ";
$sql .= "WHERE ";
$sql .= "t_direct.shop_id = $shop_id ";
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
$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "(全".$total_count_h."件)";
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
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'total_count'   => "$total_count",
));
$smarty->assign('row',$row);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
