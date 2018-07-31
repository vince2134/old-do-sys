<?php
$page_title = "行追加・行削除";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");


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
    $max_row = $_POST["max_row"]+5;
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
print_r($del_history);
print_r($_POST);

/***************************/
//初期値設定
/***************************/
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);


/****************************/
//フォーム作成（固定）
/****************************/

//hidden
$form->addElement("hidden", "del_row");             //削除行
$form->addElement("hidden", "add_row_flg");         //追加行フラグ
$form->addElement("hidden", "max_row");             //最大行数

/*****************************/
//フォーム作成（変動）
/*****************************/
//行番号カウンタ
$row_num = 1;

for($i = 0; $i < $max_row; $i++){

    //削除行判定
    if(!in_array("$i", $del_history)){
        //削除履歴
        $del_data = $del_row.",".$i;

        //商品名
        $form_good =& $form->addElement(
                "text","form_goods_name[$i]","",'size="34" maxLength="30" 
                style="color : #000000; 
                border : #ffffff 1px solid;' 
            );


        /****************************/
        //表示用HTML作成
        /****************************/
        $html .= "<tr class=\"Result1\">\n";
        $html .=    "<td align=\"right\">$row_num</td>\n";

        //商品名
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>\n";

        
        $html .=    "<td align=\"center\">";
        $html .=       "<a href=\"#\" onClick=\"javascript:Dialogue_1('削除します。',  '$del_data', 'del_row')\">削除</a>";
        $html .=    "</td>\n";

        $html .= "</tr>\n";

        //行番号を＋１
        $row_num = $row_num+1;
    }
}

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);




// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'               => "$html_header",
    'html'                      => "$html",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
