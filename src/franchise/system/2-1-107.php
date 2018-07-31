<?php
/*
 * 変更履歴
 * 1.0.0 (2006/03/16) 所属マスタの追加(suzuki-t)
 * 1.1.0 (2006/03/21) 検索処理の修正(suzuki-t)
 * 1.1.1 (2006/05/08) 検索フォーム表示ボタン追加（watanabe-k）
 * 
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.0.0 (2006/03/16)
*/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/12/14　ssl-0068　　　watanabe-k　検索フォームを表示ボタン押下時にJSエラーが表示されるバグの修正
 * 　2007/02/16         　　   watanabe-k　検索条件に支店を追加
 * 　2010/05/13  Rev.1.5 　    hashimoto-y 初期表示に検索項目だけ表示する修正
 * 　2010/09/04  Rev.1.6 　    aoyama-n    初期表示に在職中のスタッフを一覧表示するように変更
 *
 */





$page_title = "スタッフマスタ";

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
$shop_id = $_SESSION["client_id"];

/****************************/
//デフォルト値設定
/****************************/
$def_date = array(
    "form_output_type"    => "1",
    "form_state"          => "在職中",
    "form_toilet_license" => "4"
);
$form->setDefaults($def_date);

/****************************/
//部品定義
/****************************/
//登録
$form->addElement("button","new_button","登録画面","onClick=\"javascript:Referer('2-1-108.php')\"");
//変更・一覧
$form->addElement("button","change_button","変更・一覧","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//表示
$form->addElement("submit","show_button","表　示");
//クリア
$form->addElement("button","clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
//検索フォーム表示ボタン
$form->addElement("submit","form_search_button","検索フォームを表示",
                  "onClick=\"javascript:Button_Submit_1('search_button_flg', './2-1-107.php', 'true')\"");

//出力形式
$radio[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio, "form_output_type", "出力形式");
//在職識別
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "在職中","在職中");
$radio[] =& $form->createElement( "radio",NULL,NULL, "退職","退職");
$radio[] =& $form->createElement( "radio",NULL,NULL, "休業","休業");
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","全て");
$form->addGroup($radio, "form_state", "在職");
//トイレ資格診断士
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","4");
$radio[] =& $form->createElement( "radio",NULL,NULL, "１級トイレ診断士","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "２級トイレ診断士","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "無","3");
$form->addGroup($radio, "form_toilet_license", "トイレ診断資格");

//ショップコード
$text[] =& $form->createElement("text","cd1","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_client_cd[cd1]','form_client_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","cd2","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup( $text, "form_client_cd", "form_client_cd");
//スタッフコード
$text = "";
$text[] =& $form->createElement("text","cd1","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_staff_cd[cd1]','form_staff_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","cd2","テキストフォーム","size=\"3\" maxLength=\"3\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup( $text, "form_staff_cd", "form_staff_cd");

//ショップ名
$form->addElement("text","form_client_name","テキストフォーム","size=\"34\" maxLength=\"15\" ".$g_form_option."\"");
//スタッフ名
$form->addElement("text","form_staff_name","テキストフォーム","size=\"22\" maxLength=\"10\" ".$g_form_option."\"");
//担当者コード
$form->addElement("text","form_charge_cd","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
//取得資格
$form->addElement("text","form_license","テキストフォーム","size=\"34\" maxLength=\"50\" ".$g_form_option."\"");
//役職
$form->addElement("text","form_position","テキストフォーム","size=\"15\" maxLength=\"7\" ".$g_form_option."\"");
//所属部署
//$select_value = Select_Get($db_con,'part');
//$form->addElement('select', 'form_part', 'セレクトボックス', $select_value,$g_form_option_select);
$obj_bank_select =& $form->addElement("hierselect", "form_part", "", "");
$obj_bank_select->setOptions(Make_Ary_Branch($db_con));

//職種
$select_value="";
$select_value = array(
    ""         =>  "",
    "営業"     =>  "営業",
    "サービス" =>  "サービス",
    "事務"     =>  "事務",
    "その他"   =>  "その他"
);
$form->addElement('select', 'form_job_type', 'セレクトボックス', $select_value,$g_form_option_select);


//hidden
$form->addElement("hidden", "search_button_flg");


/****************************/
//表示ボタン押下処理
/****************************/
#2010-09-04 aoyama-n
#if($_POST["show_button"]=="表　示"){


    /******************************/
    //ヘッダーに表示させる全件数
    /*****************************/
    /** スタッフマスタ取得SQL作成 **/
    $sql = "SELECT  \n";
    $sql .= " t_client_union.client_cd1, \n";    //ショップコード1
    $sql .= " t_client_union.client_cd2, \n";    //ショップコード2
    $sql .= " t_client_union.client_name, \n";   //ショップ名
    $sql .= " charge_cd, \n";                    //担当者コード
    $sql .= " t_staff.staff_id,  \n";            //スタッフID
    $sql .= " staff_cd1,  \n";                   //スタッフコード１
    $sql .= " staff_cd2,  \n";                   //スタッフコード２
    $sql .= " staff_name,  \n";                  //スタッフ名
    $sql .= " t_part.part_name,  \n";            //部署名
    $sql .= " position,  \n";                    //役職
    $sql .= " job_type,  \n";                    //職種
    $sql .= " state,  \n";                       //在職識別
    $sql .= " CASE t_staff.toilet_license \n";   //トイレ診断士資格
    $sql .= "     WHEN '1' THEN '１級トイレ診断士' \n";
    $sql .= "     WHEN '2' THEN '２級トイレ診断士' \n";
    $sql .= "     WHEN '3' THEN '無' \n";
    $sql .= " END, \n";
    $sql .= " t_staff.license,  \n";              //取得資格
    $sql .= " t_branch.branch_name \n";
    $sql .= "FROM  \n";
    $sql .= " (SELECT  \n";
    $sql .= "   client_id, \n";
    //$sql .= "   attach_gid, \n";
    $sql .= "   client_cd1, \n";
    $sql .= "   client_cd2, \n";
    $sql .= "   client_name \n";
    $sql .= " FROM  \n";
    $sql .= "   t_client  \n";
    $sql .= " WHERE  \n";
    $sql .= "   client_div = '3' \n";
    $sql .= " )  \n";
    $sql .= "AS t_client_union \n";
    $sql .= "   INNER JOIN \n";
    $sql .= " t_attach  \n";
    $sql .= " ON t_client_union.client_id = t_attach.shop_id \n";
    $sql .= "   INNER JOIN  \n";
    $sql .= " t_part  \n";
    $sql .= " ON t_attach.part_id = t_part.part_id  \n";
    $sql .= "   INNER JOIN \n";
    $sql .= " t_branch \n";
    $sql .= " ON t_part.branch_id= t_branch.branch_id \n";
    $sql .= "   INNER JOIN \n";
    $sql .= " t_staff ON t_staff.staff_id = t_attach.staff_id  \n";
    $sql .= "WHERE  \n";
    //$sql .= " t_attach.shop_id = t_client_union.client_id  \n";
    //$sql .= "AND  \n";
    //直営判定
    if($_SESSION[group_kind] == '2'){
    	//直営
    	$sql .= "    t_attach.shop_id IN(".Rank_Sql().") \n";
    }else{ 
    	//ＦＣ
    	$sql .= "    t_attach.shop_id = $shop_id  \n";
    }

    #2010-05-12 hashimoto-y
    #//初期表示時、在職中のスタッフのみ表示
    #if($_POST["search_button_flg"]!=true && $_POST["show_button"]!="表　示"){
    #    $sql .= "AND state = '在職中' ";
    #    $cons_data["search_button_flg"] = "";
    #    $form->setConstants($cons_data);
    #}

    #2010-09-04 aoyama-n
    //初期表示時、在職中のスタッフのみ表示
    if($_POST["search_button_flg"]!=true && $_POST["show_button"]!="表　示"){
        $sql .= "AND state = '在職中' ";
        $cons_data["search_button_flg"] = "";
        $form->setConstants($cons_data);
        $display_flg = true;
    }

/****************************/
//表示ボタン押下処理
/****************************/
#2010-09-04 aoyama-n
if($_POST["show_button"]=="表　示"){

    $output_type = $_POST["form_output_type"];        //出力形式
    $state       = $_POST["form_state"];              //在職識別
    $job_type    = $_POST["form_job_type"];           //職種
    $client_cd1    = $_POST["form_client_cd"]["cd1"]; //ショップコード１
    $client_cd2    = $_POST["form_client_cd"]["cd2"]; //ショップコード２
    $staff_cd1   = $_POST["form_staff_cd"]["cd1"];    //スタッフコード１
    $staff_cd2   = $_POST["form_staff_cd"]["cd2"];    //スタッフコード２
    $client_name   = $_POST["form_client_name"];          //ショップ名
    $staff_name  = $_POST["form_staff_name"];         //スタッフ名
    $charge_cd   = $_POST["form_charge_cd"];          //担当者コード
    $license     = $_POST["form_license"];            //取得資格
    $position    = $_POST["form_position"];           //役職
    $branch      = $_POST["form_part"][0];            //支店
    $part        = $_POST["form_part"][1];            //部署名
    $toilet      = $_POST["form_toilet_license"];     //トイレ診断士資格

    //CSV・画面判定
    if($output_type == 1 || $output_type == null){
        //画面表示処理
		
        /** 条件指定 **/
        //ショップコード１指定の有無
        if($client_cd1 != null){
            $sql .= "AND t_client_union.client_cd1 LIKE '$client_cd1%' ";
        }
        //ショップコード２指定の有無
        if($client_cd2 != null){
            $sql .= "AND t_client_union.client_cd2 LIKE '$client_cd2%' ";
        }
        //ショップ名指定の有無
        if($client_name != null){
            $sql .= "AND t_client_union.client_name  LIKE '%$client_name%' ";
        }
        //スタッフコード１指定の有無
        if($staff_cd1 != null){
            $sql .= "AND staff_cd1 LIKE '$staff_cd1%' ";
        }
        //スタッフコード２指定の有無
        if($staff_cd2 != null){
            $sql .= "AND staff_cd2 LIKE '$staff_cd2%' ";
        }
        //スタッフ名指定の有無
        if($staff_name != null){
            $sql .= "AND staff_name LIKE '%$staff_name%' ";
        }
        //担当者コード指定の有無
        if($charge_cd != null){
			//00も000も値は一緒の為、文字を代入して判定
			$str = str_pad($charge_cd, 4, 'A', STR_POS_LEFT);
			if($str == 'A000'){
				$sql .= "AND charge_cd BETWEEN 0 AND 9 ";
			}else if($str == 'AA00'){
				$sql .= "AND charge_cd BETWEEN 0 AND 99 ";
			}else if($str == 'AAA0'){
				$sql .= "AND charge_cd BETWEEN 0 AND 999 ";
			}else{
				if(ereg("^[0-9]{1,4}$",$charge_cd)){
					$sql .= "AND charge_cd = $charge_cd ";
				}else{
					$sql .= "AND charge_cd LIKE '$charge_cd%' ";
				}
			}
        }
        //部署名指定の有無
        if($part != null){
            $sql .= "AND t_part.part_id = $part ";
        }
        //役職指定の有無
        if($position != null){
            $sql .= "AND position LIKE '%$position%' ";
        }
        //支店指定の有無
        if($branch != null){
            $sql .= "AND t_branch.branch_id = $branch ";
        }
        //職種指定の有無
        if($job_type != null){
            $sql .= "AND job_type = '$job_type' ";
        }
        //在職識別指定の有無
        if($state!='全て'){
            $sql .= "AND state = '$state' ";
        }
        //トイレ診断士資格指定の有無
        if($toilet!='4'){
            $sql .= "AND t_staff.toilet_license = '$toilet' ";
        }
        //取得資格指定の有無
        if($license != null){
            $sql .= "AND t_staff.license LIKE '%$license%' ";
        }
    
    }else{
        //CSV表示処理

        /** CSV作成SQL **/
        $sql = "SELECT ";
		$sql .= " charge_cd,";                    //担当者コード
        $sql .= " staff_cd1, ";                   //スタッフコード１
        $sql .= " staff_cd2, ";                   //スタッフコード２
        $sql .= " staff_name, ";                  //スタッフ名
        $sql .= " staff_read, ";                  //スタッフ名(フリガナ)
        $sql .= " staff_ascii, ";                 //スタッフ名(ローマ字)
        $sql .= " sex, ";                         //性別
        $sql .= " birth_day, ";                   //生年月日
        $sql .= " state, ";                       //在職識別
        $sql .= " join_day, ";                    //入社年月日
        $sql .= " retire_day, ";                  //退職日
        $sql .= " employ_type , ";                //雇用形態
        $sql .= " t_part.part_cd, ";              //部署コード
        $sql .= " t_part.part_name, ";            //所属部署名
        $sql .= " t_attach.section, ";            //所属部署（課）
        $sql .= " position, ";                    //役職
        $sql .= " job_type, ";                    //職種
        $sql .= " study, ";                       //研修履歴
        $sql .= " toilet_license, ";              //トイレ診断士資格
        $sql .= " t_staff.license, ";             //取得資格
        $sql .= " t_staff.note, ";                //備考
        $sql .= " t_ware.ware_cd, ";              //担当倉庫コード
        $sql .= " t_ware.ware_name, ";            //担当倉庫名
        $sql .= " change_flg, ";                  //変更不可能フラグ
        $sql .= " t_branch.branch_cd, ";
        $sql .= " t_branch.branch_name ";
        $sql .= "FROM ";
        $sql .= " (SELECT ";
		$sql .= "   client_id,";
//		$sql .= "   attach_gid,";
		$sql .= "   client_cd1,";
		$sql .= "   client_cd2,";
		$sql .= "   client_name";
		$sql .= " FROM ";
		$sql .= "   t_client ";
		$sql .= " WHERE ";
		$sql .= "   client_div = '3'";
		$sql .= " ) ";
        $sql .= "AS t_client_union,";
        $sql .= " t_attach ";

        $sql .= " LEFT JOIN ";
		$sql .= "     t_part ";
		$sql .= " ON t_attach.part_id = t_part.part_id ";

        $sql .= " LEFT JOIN ";
        $sql .= "    t_branch ";
        $sql .= " ON t_part.branch_id = t_branch.branch_id ";


        $sql .= " LEFT JOIN ";
        $sql .= "     t_ware ";
		$sql .= " ON t_attach.ware_id = t_ware.ware_id ";

		$sql .= " INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
        $sql .= "WHERE ";
        $sql .= " t_attach.shop_id = t_client_union.client_id ";
        $sql .= "AND ";
        //直営判定
		if($_SESSION[group_kind] == '2'){
			//直営
			$sql .= "    t_attach.shop_id IN(".Rank_Sql().")";
		}else{ 
			//ＦＣ
			$sql .= "    t_attach.shop_id = $shop_id ";
		}

        /** 条件指定 **/
        //ショップコード１指定の有無
        if($client_cd1 != null){
            $sql .= "AND t_client_union.client_cd1 LIKE '$client_cd1%' ";
        }
        //ショップコード２指定の有無
        if($client_cd2 != null){
            $sql .= "AND t_client_union.client_cd2 LIKE '$client_cd2%' ";
        }
        //ショップ名指定の有無
        if($client_name != null){
            $sql .= "AND t_client_union.client_name LIKE '%$client_name%' ";
        }
        //スタッフコード１指定の有無
        if($staff_cd1 != null){
            $sql .= "AND staff_cd1 LIKE '$staff_cd1%' ";
        }
        //スタッフコード２指定の有無
        if($staff_cd2 != null){
            $sql .= "AND staff_cd2 LIKE '$staff_cd2%' ";
        }
        //スタッフ名指定の有無
        if($staff_name != null){
            $sql .= "AND staff_name LIKE '%$staff_name%' ";
        }
        //担当者コード指定の有無
        if($charge_cd != null){
			//00も000も値は一緒の為、文字を代入して判定
			$str = str_pad($charge_cd, 4, 'A', STR_POS_LEFT);
			if($str == 'A000'){
				$sql .= "AND charge_cd BETWEEN 0 AND 9 ";
			}else if($str == 'AA00'){
				$sql .= "AND charge_cd BETWEEN 0 AND 99 ";
			}else if($str == 'AAA0'){
				$sql .= "AND charge_cd BETWEEN 0 AND 999 ";
			}else{
				if(ereg("^[0-9]{1,4}$",$charge_cd)){
					$sql .= "AND charge_cd = $charge_cd ";
				}else{
					$sql .= "AND charge_cd LIKE '$charge_cd%' ";
				}
			}
        }
        //部署名指定の有無
        if($part != null){
             $sql .= "AND t_part.part_id = $part ";
        }
        //役職指定の有無
        if($position != null){
            $sql .= "AND position LIKE '%$position%' ";
        }
        //職種指定の有無
        if($job_type != null){
            $sql .= "AND job_type = '$job_type' ";
        }
        //在職識別指定の有無
        if($state!='全て'){
            $sql .= "AND state = '$state' ";
        }
        //トイレ診断士資格指定の有無
        if($toilet!='4'){
            $sql .= "AND t_staff.toilet_license = '$toilet' ";
        }
        //取得資格指定の有無
        if($license != null){
            $sql .= "AND t_staff.license LIKE '%$license%' ";
        }
        $sql .= " ORDER BY ";
        $sql .= "charge_cd;";

        $result = Db_Query($db_con,$sql);

        //CSVデータ取得
        $i=0;
        while($data_list = pg_fetch_array($result)){

			$staff_data[$i][0]  = str_pad($data_list[0], 4, "0", STR_PAD_LEFT);     //担当者コード
            $staff_data[$i][1]  = str_pad($data_list[1], 6, "0", STR_PAD_LEFT)."-".str_pad($data_list[2], 4, "0", STR_PAD_LEFT);  //スタッフコード
            $staff_data[$i][2]  = $data_list[3];                    //スタッフ\名
            $staff_data[$i][3]  = $data_list[4];                    //スタッフ名(フリガナ)
            $staff_data[$i][4]  = $data_list[5];                    //スタッフ名(ローマ字)
            //性別判定（1:男 2:女）
            if($data_list[6]==1){
                $staff_data[$i][5]  = "男";
            }else{
                $staff_data[$i][5]  = "女";
            }                    
            $staff_data[$i][6]  = $data_list[7];                    //生年月日
            $staff_data[$i][7]  = $data_list[8];                    //在職識別
            $staff_data[$i][8]  = $data_list[9];                    //入社年月日
            $staff_data[$i][9]  = $data_list[10];                   //退職日
            $staff_data[$i][10] = $data_list[11];                   //雇用形態
            $staff_data[$i][11] = $data_list[branch_cd];                   //雇用形態
            $staff_data[$i][12] = $data_list[branch_name];                   //雇用形態
            $staff_data[$i][13] = $data_list[12];                   //所属部署コード
            $staff_data[$i][14] = $data_list[13];                   //所属部署名
            $staff_data[$i][15] = $data_list[14];                   //所属部署（課）
            $staff_data[$i][16] = $data_list[15];                   //役職
            $staff_data[$i][17] = $data_list[16];                   //職種
            $staff_data[$i][18] = $data_list[17];                   //研修履歴
            //トイレ診断士資格判定(1:１級 2:２級 3:無)
            if($data_list[18]=='1'){
                $staff_data[$i][19] = "１級トイレ診断士";    
            }else if($data_list[18]=='2'){
                $staff_data[$i][19] = "２級トイレ診断士";    
            }else{
                $staff_data[$i][19] = "無";    
            }
            $staff_data[$i][20] = $data_list[19];                    //取得資格
            $staff_data[$i][21] = $data_list[20];                    //備考
            $staff_data[$i][22] = $data_list[21];                    //担当倉庫コード
            $staff_data[$i][23] = $data_list[22];                    //担当倉庫名
            //変更不可能フラグ判定(t:変更不可 f:変更可)
            if($data_list[23]==true){
                $staff_data[$i][24] = "変更不可";
            }else{
                $staff_data[$i][24] = "変更可";
            }
            $i++;
        }

        //CSVファイル名
        $csv_file_name = "スタッフマスタ".date("Ymd").".csv";
        //CSVヘッダ作成
        $csv_header = array(
			"担当者コード",
            "スタッフコード", 
            "スタッフ名",
            "スタッフ名(フリガナ)",
            "スタッフ名(ローマ字)",
            "性別",
            "生年月日",
            "在職識別",
            "入社年月日",
            "退職日", 
            "雇用形態",
            "支店コード",
            "支店名",
            "所属部署コード",
            "所属部署名",
            "所属部署（課）",
            "役職",
            "職種",
            "研修履歴",
            "トイレ診断士資格",
            "取得資格",
            "備考",
            "担当倉庫コード",
            "担当倉庫名",
            "変更不可能フラグ"
        );
        $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
        $csv_data = Make_Csv_Staff($staff_data, $csv_header);
        Header("Content-disposition: attachment; filename=$csv_file_name");
        Header("Content-type: application/octet-stream; name=$csv_file_name");
        print $csv_data;
        exit;
    }

#2010-09-04 aoyama-n
$display_flg = true;
}

    $result = Db_Query($db_con,$sql." ORDER BY t_client_union.client_cd1, t_client_union.client_cd2, charge_cd;");
    //全件数取得(データ)
    $total_count = pg_num_rows($result);

    //行データ部品を作成
    $row = Get_Data($result,$output_type);
    //担当者コードを0埋めする
    for($i=0;$i<count($row);$i++){
        $row[$i][3] = str_pad($row[$i][3], 4, 0, STR_POS_LEFT);
    }

    //重複を削除
    for($i = 0; $i < count($row); $i++){
        for($j = 0; $j < count($row); $j++){
            if($i != $j && $row[$i][0] == $row[$j][0] && $row[$i][1] == $row[$j][1]){
                $row[$j][0] = null;
                $row[$j][1] = null;
                $row[$j][2] = null;
            }
        }
    }

    //trのbgcolor設定
    for($i = 0; $i < count($row); $i++){
        if($i == 0){
            $tr[$i] = "Result1";
        }elseif($row[$i][0] == null){
            $tr[$i] = $tr[$i-1];
        }else{
            if($tr[$i-1] == "Result1"){
                $tr[$i] = "Result2";
            }else{
                $tr[$i] = "Result1";
            }
        }
    }


#2010-09-04 aoyama-n
#2010-05-12 hashimoto-y
#$display_flg = true;
#}

/******************************/
// CSV作成関数（スタッフマスタ用）
/*****************************/
function Make_Csv_Staff($row ,$header){

    //レコードが無い場合は、CSVデータにNULLを表示させる
    if(count($row)==0){
        $row[] = array("","");
    }

    // 配列にヘッダ行を追加
    $count = array_unshift($row, $header);

    // 整形 
    for($i = 0; $i < $count; $i++){
        for($j = 0; $j < count($row[$i]); $j++){
            $row[$i][$j] = str_replace("\r\n", "　", $row[$i][$j]);
            $row[$i][$j] = str_replace("\"", "\"\"", $row[$i][$j]);
            $row[$i][$j] = "\"".$row[$i][$j]."\"";
        }       
        // 配列をカンマ区切りで結合
        $data_csv[$i] = implode(",", $row[$i]);
    }
    $data_csv = implode("\n", $data_csv);
    // エンコーディング
    $data_csv = mb_convert_encoding($data_csv, "SJIS", "EUC-JP");
    return $data_csv;

}


/******************************/
//ヘッダーに表示させる全件数
/*****************************/
/** スタッフマスタ取得SQL作成 **/
$sql  = "SELECT ";
$sql .= "    count(staff_id) ";                    //スタッフID
$sql .= "FROM ";
$sql .= "    t_attach ";
$sql .= "WHERE ";
$sql .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".(Rank_Sql()).") " : " shop_id = $shop_id ";
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
if ($_SESSION["group_kind"] != "2"){
    $page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
    $page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
}
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
    'total_count'    => "$total_count",
    'display_flg'    => "$display_flg",
));
$smarty->assign('tr',$tr);

$smarty->assign('row',$row);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
