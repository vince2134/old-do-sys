//DONE TRANSLATION.

<?php
/*
 * revisions and update history
 * 1.0.0 (2006/03/16) Added Affiliation master(suzuki-t)
 * 1.1.0 (2006/03/21) Fixed search process(suzuki-t)
 * 1.1.1 (2006/05/08) Added search form view process（watanabe-k）
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.1.0 (2006/03/21)
*/

/*
 * History (will not translate this anymore since its just a history of revisions)：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-07      ban_0093    suzuki      検索フォーム表示ボタン押下時に在職中のスタッフのみ表示
 *  2007-01-23      仕様変更    watanabe-k  ボタンの色を変更
 *  2007-02-19                  watanabe-k  検索条件に支店を追加
 *  2010-05-12      Rev.1.5     hashimoto-y 初期表示に検索項目だけ表示する修正
 *  2010-09-04      Rev.1.6     aoyama-n    初期表示に在職中のスタッフを一覧表示するように変更
 *   2016/01/21                amano  Button_Submit_1 関数でボタン名が送られない IE11 バグ対応  
 *  
 *
*/

$page_title = "スタッフマスタ";

//Envirionment setting file
require_once("ENV_local.php");

//Create HTML_QuickForm
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//Connect to DataBase 
$db_con = Db_Connect();

// Checking of Authority
$auth       = Auth_Check($db_con);

/****************************/
//Acquire Variables from outside
/****************************/
$shop_id  = $_SESSION[client_id];

/****************************/
//Set up default value
/****************************/
$def_date = array(
    "form_output_type"    => "1",
    "form_state"          => "在職中",
    "form_toilet_license" => "4"
);
$form->setDefaults($def_date);

/****************************/
//Definition of components
/****************************/
//Registre
$form->addElement("button","new_button","登録画面","onClick=\"javascript:Referer('1-1-109.php')\"");
//Changes・List
//$form->addElement("button","change_button","変更・一覧","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","変更・一覧",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//View
$form->addElement("submit","show_button","表　示");
//Clear
$form->addElement("button","clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
//Search button
$form->addElement("submit","form_search_button","検索フォームを表示",
                  "onClick=\"javascript:Button_Submit_1('search_button_flg', '#', 'true', this)\""); 

//Output format
$radio[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio, "form_output_type", "出力形式");
//Tenure Classification
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "在職中","在職中");
$radio[] =& $form->createElement( "radio",NULL,NULL, "退職","退職");
$radio[] =& $form->createElement( "radio",NULL,NULL, "休業","休業");
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","全て");
$form->addGroup($radio, "form_state", "在職");
//Toilet consultant license
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","4");
$radio[] =& $form->createElement( "radio",NULL,NULL, "１級トイレ診断士","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "２級トイレ診断士","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "無","3");
$form->addGroup($radio, "form_toilet_license", "トイレ診断資格");

//Shop code
$text[] =& $form->createElement("text","cd1","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_client_cd[cd1]','form_client_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","cd2","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"  ".$g_form_option."\"");
$form->addGroup( $text, "form_client_cd", "form_client_cd");
//staff code
$text = "";
$text[] =& $form->createElement("text","cd1","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_staff_cd[cd1]','form_staff_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","cd2","テキストフォーム","size=\"3\" maxLength=\"3\" style=\"$g_form_style\"  ".$g_form_option."\"");
$form->addGroup( $text, "form_staff_cd", "form_staff_cd");

//issue date
$text="";
$text[] =& $form->createElement("text", "y", "",
        "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_issue_date[y]', 'form_issue_date[m]',4)\"
         onFocus=\"onForm_today(this,this.form,'form_issue_date[y]','form_issue_date[m]','form_issue_date[d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("text", "m", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_issue_date[m]', 'form_issue_date[d]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_issue_date[y]','form_issue_date[m]','form_issue_date[d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("text", "d", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onFocus=\"onForm_today(this,this.form,'form_issue_date[y]','form_issue_date[m]','form_issue_date[d]')\"
         onBlur=\"blurForm(this)\""
);

$form->addGroup($text, "form_issue_date", "form_issue_date", "-");

//shop name
$form->addElement("text","form_client_name","テキストフォーム","size=\"34\" maxLength=\"15\" ".$g_form_option."\"");
//staff name
$form->addElement("text","form_staff_name","テキストフォーム","size=\"22\" maxLength=\"10\" ".$g_form_option."\"");
//person in charge code
$form->addElement("text","form_charge_cd","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
//acquired license
$form->addElement("text","form_license","テキストフォーム","size=\"34\" maxLength=\"50\" ".$g_form_option."\"");
//position
$form->addElement("text","form_position","テキストフォーム","size=\"15\" maxLength=\"7\" ".$g_form_option."\"");
//belonged department
/*
$select_value = Select_Get($db_con,'part');
$form->addElement('select', 'form_part', 'セレクトボックス', $select_value,$g_form_option_select);
*/

//Occupation
$select_value="";
$select_value = array(
    ""         =>  "",
    "営業"     =>  "営業",
    "サービス" =>  "サービス",
    "事務"     =>  "事務",
    "その他"   =>  "その他"
);
$form->addElement('select', 'form_job_type', 'セレクトボックス', $select_value,$g_form_option_select);

//Staff classification
$select_value = array(
	"",
	"FCスタッフ",
	"直営スタッフ",
	"本部スタッフ",
	"本部・直営スタッフ",
);
$form->addElement('select', 'form_staff_kind','セレクトボックス',$select_value,$g_form_option_select);

//hidden
$form->addElement("hidden", "search_button_flg");



/****************************/
//Process of view/display button when pressed
/****************************/
#2010-09-04 aoyama-n
#if($_POST["show_button"]=="表　示　Display"){


    /******************************/
    //number of all items that will be displayed in the header
    /*****************************/
    /** Createa SQL that will acquire the staff master **/
    $sql = "SELECT \n";
    $sql .= "   CASE t_rank.group_kind\n";                //スタッフ種別 Staff classification
    //$sql .= "       WHEN '1' THEN '○'\n";
    $sql .= "       WHEN '2' THEN '○'\n";
    $sql .= "       WHEN '3' THEN NULL\n";
    $sql .= "   END,\n";
    $sql .= "   t_client_union.client_cd1,\n";            //shop code1
    $sql .= "   t_client_union.client_cd2,\n";            //shop code2
    $sql .= "   t_client_union.client_name,\n";           //Shop name
    $sql .= "   charge_cd,\n";                            //person in charge code
    $sql .= "   t_staff.staff_id, \n";                    //Staff ID
    $sql .= "   staff_cd1, \n";                           //shop code1
    $sql .= "   staff_cd2, \n";                           //shop code2
    $sql .= "   staff_name, \n";                          //Staff name
    $sql .= "   t_part.part_name, \n";                    //Department name
    $sql .= "   position, \n";                            //position
    $sql .= "   job_type, \n";                            //occupation
    $sql .= "   state, \n";                               //tenure classification
    $sql .= "   CASE t_staff.toilet_license\n";           //Toilet consultant license
    $sql .= "       WHEN '1' THEN '１級トイレ診断士'\n";
    $sql .= "       WHEN '2' THEN '２級トイレ診断士'\n";
    $sql .= "       WHEN '3' THEN '無'\n";
    $sql .= "   END,\n";
    $sql .= "   t_staff.license, \n";                     //Acquired license
    $sql .= "   t_branch.branch_name \n";
    $sql .= "FROM \n";
    $sql .= "   (SELECT \n";
    $sql .= "       client_id,\n";
    $sql .= "       client_cd1,\n";
    $sql .= "       client_cd2,\n";
    $sql .= "       client_name,\n";
    $sql .= "       rank_cd \n";
    $sql .= "   FROM \n";
    $sql .= "       t_client \n";
    $sql .= "   WHERE \n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       (client_div = '3' OR client_div = '0')\n";
    $sql .= "   ) AS t_client_union \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_rank\n";
    $sql .= "   ON t_rank.rank_cd = t_client_union.rank_cd \n";
    $sql .= "   AND t_rank.group_kind != '1' \n"; // will not acquire the HQ staff（because direcatly managed store's staff = HQ staff）
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_attach \n";
    $sql .= "   ON t_attach.shop_id = t_client_union.client_id \n";
    $sql .= "       LEFT JOIN \n";
    $sql .= "   t_part \n";
    $sql .= "   ON t_attach.part_id = t_part.part_id \n";
    $sql .= "   AND t_attach.h_staff_flg = 'f' \n";
    $sql .= "       LEFT JOIN \n";
    $sql .= "   t_branch \n";
    $sql .= "   ON t_part.branch_id = t_branch.branch_id \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_staff\n";
    $sql .= "   ON t_staff.staff_id = t_attach.staff_id \n";
    $sql .= "WHERE \n";
    //$sql .= "   t_attach.shop_id = t_client_union.client_id ";
    $sql .= "   t_rank.rank_cd IS NOT NULL \n";


    #2010-05-12 hashimoto-y
    #//Initial display/view Only display staff that are currently in tenure
    #if(($_POST["search_button_flg"]==true && $_POST["show_button"]!="表　示") || count($_POST) == 0){
    #    $sql .= "AND state = '在職中 in tenure' ";
    #    $cons_data["search_button_flg"] = "";
    #    $form->setConstants($cons_data);
    #}

    #2010-09-04 aoyama-n
    //Initial display/view Only display staff that are currently in tenure
    if(($_POST["search_button_flg"]==true && $_POST["show_button"]!="表　示 display") || count($_POST) == 0){
        $sql .= "AND state = '在職中 in tenure' ";
        $cons_data["search_button_flg"] = "";
        $form->setConstants($cons_data);
        $display_flg = true;
    }

/****************************/
//process when pressed the view/display button
/****************************/
#2010-09-04 aoyama-n
if($_POST["show_button"]=="表　示"){

    $output_type = $_POST["form_output_type"];        //Ouput format
	$staff_kind  = $_POST["form_staff_kind"];         //staff classification
    $state       = $_POST["form_state"];              //tenure classifcation
    $job_type    = $_POST["form_job_type"];           //occupation
    $client_cd1  = $_POST["form_client_cd"]["cd1"];   //shop code1
    $client_cd2  = $_POST["form_client_cd"]["cd2"];   //shop code２
    $staff_cd1   = $_POST["form_staff_cd"]["cd1"];    //staff code１
    $staff_cd2   = $_POST["form_staff_cd"]["cd2"];    //staff code２
    $client_name = $_POST["form_client_name"];        //shop name
    $staff_name  = $_POST["form_staff_name"];         //staff name
    $charge_cd   = $_POST["form_charge_cd"];          //person in charge code
    $license     = $_POST["form_license"];            //acquired license
    $position    = $_POST["form_position"];           //position
    $part        = $_POST["form_part"];               //department name
    $toilet      = $_POST["form_toilet_license"];     //toilet consultant license

    //CSV・画面判定 CSV・Decision of which screen
    if($output_type == 1 || $output_type == null){
        //Screen view/display process
        
        /** Condition specification **/
		//Necessity of Staff occupation specification
        if($staff_kind != null && $staff_kind != '0'){
			if($staff_kind == 4){
				//HQ・Dicrectly managed store
				$sql .= "AND t_attach.sys_flg = 't' ";
			}else{
				//Match the Database format
				if($staff_kind == 1){
					//ＦＣ
					$staff_kind = 3;
				}else if($staff_kind == 3){
					//HQ
					$staff_kind = 1;
				}
	            $sql .= "AND t_rank.group_kind = '$staff_kind' ";
			}
        }
        //Necessity of shop code 1 specification
        if($client_cd1 != null){
            $sql .= "AND t_client_union.client_cd1 LIKE '$client_cd1%' ";
        }
        //Necessity of shop code 2 specification
        if($client_cd2 != null){
            $sql .= "AND t_client_union.client_cd2 LIKE '$client_cd2%' ";
        }
        //Necessity of shop name specification
        if($client_name != null){
            $sql .= "AND t_client_union.client_name LIKE '%$client_name%' ";
        }
        //Necessity of staff code 1 specification
        if($staff_cd1 != null){
            $sql .= "AND staff_cd1 LIKE '$staff_cd1%' ";
        }
        //Necessity of staff code 2 specification
        if($staff_cd2 != null){
            $sql .= "AND staff_cd2 LIKE '$staff_cd2%' ";
        }
        //Necessity of staff name specification
        if($staff_name != null){
            $sql .= "AND staff_name LIKE '%$staff_name%' ";
        }
        //Necessity of person in charge code specification
        if($charge_cd != null){
			//00 and 000 is the same so replace it with a string and determine
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
        //Necessity of department name specification
        if($part != null){
            $sql .= "AND t_part.part_id = $part ";
        }
        //Necessity of position specification
        if($position != null){
            $sql .= "AND position LIKE '%$position%' ";
        }
        //Necessity of occupation specification
        if($job_type != null){
            $sql .= "AND job_type = '$job_type' ";
        }
        //Necessity of tenurship classification specification
        if($state != '全て'){
            $sql .= "AND state = '$state' ";
        }
        //Necessity of specificing if toilet consultant license was acquired or not
        if($toilet!='4'){
            $sql .= "AND t_staff.toilet_license = '$toilet' ";
        }
        //Necessity of acquired license specification
        if($license != null){
            $sql .= "AND t_staff.license LIKE '%$license%' ";
        }
    
    }else{
        //CSV view/display process

        /** Create sql that acquire staff master **/
        $sql = "SELECT \n";
        $sql .= "   CASE t_rank.group_kind\n";                //Staff classification
        //$sql .= "       WHEN '1' THEN '○'\n";
        $sql .= "       WHEN '2' THEN '○'\n";
        $sql .= "       WHEN '3' THEN NULL\n";
        $sql .= "   END,\n";
        $sql .= "   t_client_union.client_cd1,\n";            //Shop code 1
        $sql .= "   t_client_union.client_cd2,\n";            //Shop code 2
        $sql .= "   t_client_union.client_name,\n";           //Shop name
        $sql .= "   charge_cd,\n";                            //Person in charge code
        $sql .= "   t_staff.staff_id, \n";                    //Staff ID
        $sql .= "   staff_cd1, \n";                           //Staff code １
        $sql .= "   staff_cd2, \n";                           //Staff code ２
        $sql .= "   staff_name, \n";                          //Staff nam
        $sql .= "   t_part.part_name, \n";                    //Department name
        $sql .= "   position, \n";                            //Position
        $sql .= "   job_type, \n";                            //Occupation
        $sql .= "   state, \n";                               //Tenureship classification
        $sql .= "   CASE t_staff.toilet_license\n";           //Toilet consultant license
        $sql .= "       WHEN '1' THEN '１級トイレ診断士'\n";
        $sql .= "       WHEN '2' THEN '２級トイレ診断士'\n";
        $sql .= "       WHEN '3' THEN '無'\n";
        $sql .= "   END,\n";
        $sql .= "   t_staff.license, \n";                     //Acquired license
        $sql .= "   t_branch.branch_name \n";
        $sql .= "FROM \n";
        $sql .= "   (SELECT \n";
        $sql .= "       client_id,\n";
        $sql .= "       client_cd1,\n";
        $sql .= "       client_cd2,\n";
        $sql .= "       client_name,\n";
        $sql .= "       rank_cd \n";
        $sql .= "   FROM \n";
        $sql .= "       t_client \n";
        $sql .= "   WHERE \n";
        $sql .= "       shop_id = $shop_id\n";
        $sql .= "       AND\n";
        $sql .= "       (client_div = '3' OR client_div = '0')\n";
        $sql .= "   ) AS t_client_union \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_rank\n";
        $sql .= "   ON t_rank.rank_cd = t_client_union.rank_cd \n";
        $sql .= "   AND t_rank.group_kind != '1' \n"; // do not acuire the HQ staff（Because directly manageed staff = HQ Staff）
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_attach \n";
        $sql .= "   ON t_attach.shop_id = t_client_union.client_id \n";
        $sql .= "       LEFT JOIN \n";
        $sql .= "   t_part \n";
        $sql .= "   ON t_attach.part_id = t_part.part_id \n";
        $sql .= "   AND t_attach.h_staff_flg = 'f' \n";
        $sql .= "       LEFT JOIN \n";
        $sql .= "   t_branch \n";
        $sql .= "   ON t_part.branch_id = t_branch.branch_id \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_staff\n";
        $sql .= "   ON t_staff.staff_id = t_attach.staff_id \n";
        $sql .= "WHERE \n";
        //$sql .= "   t_attach.shop_id = t_client_union.client_id ";
        $sql .= "   t_rank.rank_cd IS NOT NULL \n";

        /** SQL that creates CSV **/
        $sql = "SELECT \n";
        $sql .= " t_client_union.client_cd1,";    //Shop code 1
        $sql .= " t_client_union.client_cd2,";    //Shop code 2
        $sql .= " t_client_union.client_name,";   //Shop name
		$sql .= " t_staff.charge_cd,";            //person in charge code 
		$sql .= " CASE t_rank.group_kind";        //Staff classification
//		$sql .= "     WHEN '1' THEN '○'";
		$sql .= "     WHEN '2' THEN '○'";
		$sql .= "     WHEN '3' THEN NULL";
		$sql .= " END,";
        $sql .= " t_staff.staff_cd1, ";           //Staff code １
        $sql .= " t_staff.staff_cd2, ";           //staff code ２
        $sql .= " t_staff.staff_name, ";          //staff name 
        $sql .= " t_staff.staff_read, ";          //Staff name ("Furigana" (spelling of the name in a japanese alphabet called katakana))
        $sql .= " t_staff.staff_ascii, ";         //Staff name ("Roman-ji" (spelling of the name in english alphabet))
        $sql .= " t_staff.sex, ";                 //Sex :D
        $sql .= " t_staff.birth_day, ";           //date of birth
        $sql .= " t_staff.state, ";               //tenureship classification
        $sql .= " t_staff.join_day, ";            //date of joining the company
        $sql .= " t_staff.retire_day, ";          //date of retirement
        $sql .= " t_staff.employ_type , ";        //employment type
        $sql .= " t_part.part_cd, ";              //department code
        $sql .= " t_part.part_name, ";            //belonged department name
        $sql .= " t_attach.section, ";            //belonged department division name
        $sql .= " t_staff.position, ";            //position
        $sql .= " t_staff.job_type, ";            //occupatin
        $sql .= " t_staff.study, ";               //history of training 
        $sql .= " t_staff.toilet_license, ";      //toilet consultant license
        $sql .= " t_staff.license, ";             //acquired license
        $sql .= " t_staff.note, ";                //remarks
        $sql .= " t_ware.ware_cd, ";              //assigned warehouse code
        $sql .= " t_ware.ware_name, ";            //assigned warehouse name
        $sql .= " change_flg, ";                  //change not allowed flag
        $sql .= " branch_cd, ";                   //branch code
        $sql .= " branch_name ";                  //branch name
        $sql .= "FROM ";
        $sql .= " (SELECT ";
		$sql .= "   client_id,";
//		$sql .= "   attach_gid,";
		$sql .= "   client_cd1,";
		$sql .= "   client_cd2,";
		$sql .= "   client_name,";
		$sql .= "   rank_cd ";
		$sql .= " FROM ";
		$sql .= "   t_client ";
		$sql .= " WHERE ";
		$sql .= "   shop_id = $shop_id";
		$sql .= " AND";
		$sql .= "   (client_div = '3' OR client_div = '0')";
		$sql .= " ) ";
		$sql .= "AS t_client_union ";
		$sql .= " INNER JOIN t_rank ON t_rank.rank_cd = t_client_union.rank_cd AND t_rank.group_kind != '1', ";
        $sql .= " t_attach ";

        $sql .= " LEFT JOIN ";
		$sql .= "     t_part ";
		$sql .= " ON t_attach.part_id = t_part.part_id ";
        $sql .= " AND t_attach.h_staff_flg = 'f'";

        $sql .= " LEFT JOIN ";
        $sql .= "     t_branch ";
        $sql .= " ON t_part.branch_id = t_branch.branch_id ";

        $sql .= " LEFT JOIN ";
        $sql .= "     t_ware ";
		$sql .= " ON t_attach.ware_id = t_ware.ware_id ";

		$sql .= " INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";

        $sql .= "WHERE ";
        $sql .= " t_attach.shop_id = t_client_union.client_id ";

        /** condition specification **/
		//necessity of staff classification specification
        if($staff_kind != null && $staff_kind != '0'){
			if($staff_kind == 4){
				//HQ・Directly managed store 
				$sql .= "AND t_attach.sys_flg = 't' ";
			}else{
				//match the Database format
				if($staff_kind == 1){
					//ＦＣ
					$staff_kind = 3;
				}else if($staff_kind == 3){
					//HQ
					$staff_kind = 1;
				}
	            $sql .= "AND t_rank.group_kind = '$staff_kind' ";
			}
        }
        //necessity of shop code 1 specification
        if($client_cd1 != null){
            $sql .= "AND t_client_union.client_cd1 LIKE '$client_cd1%' ";
        }
        //necessity of shop code 2 specification
        if($client_cd2 != null){
            $sql .= "AND t_client_union.client_cd2 LIKE '$client_cd2%' ";
        }
        //necessity of shop name specification
        if($client_name != null){
            $sql .= "AND t_client_union.client_name LIKE '%$client_name%' ";
        }
        //necessity of staff code 1 specification
        if($staff_cd1 != null){
            $sql .= "AND staff_cd1 LIKE '$staff_cd1%' ";
        }
        //necessity of staff code 2 specification
        if($staff_cd2 != null){
            $sql .= "AND staff_cd2 LIKE '$staff_cd2%' ";
        }
        //necessity of staff name specification
        if($staff_name != null){
            $sql .= "AND staff_name LIKE '%$staff_name%' ";
        }

        //necessity of person in charge code specification
        if($charge_cd != null){
			//00 and 000 is the same so replace it with a string and determine
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
        //necessity of department name specification
        if($part != null){
            $sql .= "AND t_part.part_id = $part ";
        }
        //necessity of position specification
        if($position != null){
            $sql .= "AND position LIKE '%$position%' ";
        }
        //necessity of occupation specification
        if($job_type != null){
            $sql .= "AND job_type = '$job_type' ";
        }
        //necessity of tenureship classification specification
        if($state!='全て'){
            $sql .= "AND state = '$state' ";
        }
        //necessity of toilet consultant classifcation specification
        if($toilet!='4'){
            $sql .= "AND t_staff.toilet_license = '$toilet' ";
        }
        //necessity of acquired license specification
        if($license != null){
            $sql .= "AND t_staff.license LIKE '%$license%' ";
        }
        $sql .= "ORDER BY ";
        $sql .= "t_client_union.client_cd1, t_client_union.client_cd2, charge_cd;";

        $result = Db_Query($db_con,$sql);
        //Acquire CSV data
        $i=0;
        while($data_list = pg_fetch_array($result)){

            $staff_data[$i][0]  = $data_list[0]."-".$data_list[1];  //Shop code 
            $staff_data[$i][1]  = $data_list[2];                    //Shop name
            $staff_data[$i][2]  = str_pad($data_list[3], 4, "0", STR_PAD_LEFT);                    //person in charge code
			$staff_data[$i][3]  = $data_list[4];                    //staff classfication
			$staff_data[$i][4]  = str_pad($data_list[5], 6, "0", STR_PAD_LEFT)."-".str_pad($data_list[6], 4, "0", STR_PAD_LEFT);  //staff code
            $staff_data[$i][5]  = $data_list[7];                    //staff name
            $staff_data[$i][6]  = $data_list[8];                    ////Staff name ("Furigana" (spelling of the name in a japanese alphabet called katakana))
            $staff_data[$i][7]  = $data_list[9];                    //Staff name ("Roman-ji" (spelling of the name in english alphabet))
            //determine sex（1:男male 2:女female）
            if($data_list[10]==1){
                $staff_data[$i][8]  = "男";
            }else{
                $staff_data[$i][8]  = "女";
            }                    
            $staff_data[$i][9]  = $data_list[11];                    //date of birth
            $staff_data[$i][10] = $data_list[12];                    //occupation classification
            $staff_data[$i][11] = $data_list[13];                    //date of joining the company
            $staff_data[$i][12] = $data_list[14];                    //date of retirement/leaving the company
            $staff_data[$i][13] = $data_list[15];                    //employment type
            $staff_data[$i][14] = $data_list[branch_cd];             //branch code
            $staff_data[$i][15] = $data_list[branch_name];           //branch name
            $staff_data[$i][16] = $data_list[16];                    //belonged department code
            $staff_data[$i][17] = $data_list[17];                    //belonged department name
            $staff_data[$i][18] = $data_list[18];                    //belonged department division name
            $staff_data[$i][19] = $data_list[19];                    //position
            $staff_data[$i][20] = $data_list[20];                    //occupation
            $staff_data[$i][21] = $data_list[21];                    //training history
            //determine toilet counsltant license(1:１級(first class) 2:２級(second class) 3:無(none))
            if($data_list[22]=='1'){
                $staff_data[$i][22] = "１級トイレ診断士";    
            }else if($data_list[22]=='2'){
                $staff_data[$i][22] = "２級トイレ診断士";    
            }else{
                $staff_data[$i][22] = "無";    
            }
            $staff_data[$i][23] = $data_list[23];                    //acquired license
            $staff_data[$i][24] = $data_list[24];                    //remarks
            $staff_data[$i][25] = $data_list[25];                    //assigned warehouse code
            $staff_data[$i][26] = $data_list[26];                    //assigned warehouse name
            //determine *change not allowed flag*(t:変更不可change not allowed f:変更可change allowed)
            if($data_list[27]==true){
                $staff_data[$i][27] = "変更不可";
            }else{
                $staff_data[$i][27] = "変更可";
            }
            $i++;
        }

        //csv file name
        $csv_file_name = "スタッフマスタ".date("Ymd").".csv";
        //create csv header CSVヘッダ作成
        $csv_header = array(
            "ショップコード", 
            "ショップ名", 
            "担当者コード",
			"本部", 
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

    //Acquire all items (data)
    $total_count = pg_num_rows($result);

    //create row data component
    $row = Get_Data($result,$output_type);


    //fill person in charge code with 0
    for($i=0;$i<count($row);$i++){
        $row[$i][4] = str_pad($row[$i][4], 4, 0, STR_POS_LEFT);
    }

    //delete duplicates/redundancy
    for($i = 0; $i < count($row); $i++){
        for($j = 0; $j < count($row); $j++){
            if($i != $j && $row[$i][1] == $row[$j][1] && $row[$i][2] == $row[$j][2]){
                $row[$j][1] = null;
                $row[$j][2] = null;
                $row[$j][3] = null;
            }                
        }
    }

    //change TR color
    for($i = 0; $i < count($row); $i++){
        if($i == 0){
            $tr[$i] = "Result1";
        }elseif($row[$i][1] == null){
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
// function for creating CSV (for staff master)
/*****************************/
function Make_Csv_Staff($row ,$header){

    //If there is no record, display NULL in CSV data
    if(count($row)==0){
        $row[] = array("","");
    }

    // add a header row in array
    $count = array_unshift($row, $header);

    // formatiing 
    for($i = 0; $i < $count; $i++){
        for($j = 0; $j < count($row[$i]); $j++){
            $row[$i][$j] = str_replace("\r\n", "　", $row[$i][$j]);
            $row[$i][$j] = str_replace("\"", "\"\"", $row[$i][$j]);
            $row[$i][$j] = "\"".$row[$i][$j]."\"";
        }       
        // combine array with comma separation
        $data_csv[$i] = implode(",", $row[$i]);
    }
    $data_csv = implode("\n", $data_csv);
    // encoding 
    $data_csv = mb_convert_encoding($data_csv, "SJIS", "EUC-JP");
    return $data_csv;

}


/******************************/
// JS for issuance link 
/*****************************/
$js  = "function Print_Link(staff_id){\n";
$js .= "    var form_y = \"form_issue_date[y]\";\n";
$js .= "    var form_m = \"form_issue_date[m]\";\n";
$js .= "    var form_d = \"form_issue_date[d]\";\n";
$js .= "    var y = document.dateForm.elements[form_y].value\n";
$js .= "    var m = document.dateForm.elements[form_m].value\n";
$js .= "    var d = document.dateForm.elements[form_d].value\n";
$js .= "    window.open('1-1-108.php?staff_id='+staff_id+'&y='+y+'&m='+m+'&d='+d, '_blank');\n";
$js .= "}\n";


/******************************/
//all items that will be displayed in the header
/*****************************/
/** create sql that will acquire staff master **/
$sql = "SELECT ";
$sql .= "count(staff_id) ";                    //staff ID
$sql .= "FROM ";
$sql .= "t_attach ";
$sql .= "WHERE shop_id != 1 ";
$sql .= ";";
$result = Db_Query($db_con,$sql.";");
//number of all items aquired(header)
$total_count_h = pg_fetch_result($result,0,0);

/****************************/
//HTMLheader
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLfooter
/****************************/
$html_footer = Html_Footer();

/****************************/
//create menu
/****************************/
$page_menu = Create_Menu_h('system','1');
/****************************/
//screem header creation
/****************************/
$page_title .= "(全".$total_count_h."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);


// settings related to Render
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//assign form related variable
$smarty->assign('form',$renderer->toArray());

//assign other variables
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'total_count'   => "$total_count",
    'display_flg'    => "$display_flg",
));
$smarty->assign('row',$row);
$smarty->assign('tr',$tr);
$smarty->assign('js',$js);
//pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
