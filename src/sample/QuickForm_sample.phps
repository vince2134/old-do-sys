<?php

require_once "HTML/QuickForm.php";

//HTML_QuickFormオブジェクト生成
$form =& new HTML_QuickForm( "test_form","POST","",null,null,true);
$form->addElement("header", "title", "ヘッダータイトル");

//ニックネーム
$form->addElement("text","nick_name","ニックネーム：",'size="40"');

//性別
$sex[] =& $form->createElement( "radio",NULL,NULL, "男性","1");
$sex[] =& $form->createElement( "radio",NULL,NULL, "女性","2");
$form->addGroup( $sex, "sex", "性別：");

//年齢
$age[] =& $form->createElement( "radio",NULL,NULL,"10代","1");
$age[] =& $form->createElement( "radio",NULL,NULL,"20代","2");
$age[] =& $form->createElement( "radio",NULL,NULL,"30代","3");
$age[] =& $form->createElement( "radio",NULL,NULL,"40代","4");
$age[] =& $form->createElement( "radio",NULL,NULL,"50代","5");
$age[] =& $form->createElement( "radio",NULL,NULL,"60代以上", "6");
$form->addGroup( $age, "age", "年齢：");

//職業
$job[] =& $form->createElement( "radio",NULL,NULL,"学生","1");
$job[] =& $form->createElement( "radio",NULL,NULL,"会社","2");
$job[] =& $form->createElement( "radio",NULL,NULL,"自営業", "3");
$job[] =& $form->createElement( "radio",NULL,NULL,"主婦","4");
$job[] =& $form->createElement( "radio",NULL,NULL,"フリーター", "5");
$job[] =& $form->createElement( "radio",NULL,NULL,"無職","6");
$form->addGroup( $job,"job","職業：");

//都道府県
$ken_arr = array(
 toukyou => "東京",
 oosaka  => "大阪",
 fukuoka => "福岡",
);
$form->addElement('select', 'ken', '都道府県', $ken_arr);

//メールアドレス
$form->addElement( "text", "mail_address", "メールアドレス：",array('size'=>40));

//再度メーアドレス
$form->addElement( "text", "mail_address2", "メールアドレス確認：",array('size'=>40));

//全要素にtrimフィルターを適用
$form->applyFilter('__ALL__','trim');


//デフォルト値の設定
$def = array(
    "nick_name"     => "ニックネーム",
    "sex"     => "1",
    "age"     => "2",
    "job"     => "2",
    "ken"     => "oosaka",
);
$form->setDefaults($def);
        

//空文字チェック
$form->addRule( "nick_name", "ニックネームを入力して下さい。", "required", NULL, "client");
$form->addRule( "sex", "性別が選択されていません","required", NULL, "client");
$form->addRule( "age", "年齢が選択されていません","required", NULL, "client");
$form->addRule( "job", "職業が選択されていません","required", NULL, "client");
$form->addRule( "ken", "都道府県が選択されていません","required", NULL, "client");
$form->addRule( "mail_address", "メールアドレスを入力して下さい。", "required", NULL, "client");
$form->addRule( "mail_address2", "メールアドレス確認を入力して下さい。", "required", NULL, "client");


//マルチバイトの文字数チェックを追加
$form->registerRule("mb_maxlength","function","mb_maxlength_hoge");
function mb_maxlength_hoge( $val1, $val2, $val3 ) {
  if ( mb_strlen( $val2, "EUC-JP") <= $val3 ) return true;
  return false;
} 

//内容チェック
$form->addRule( "nick_name", "ニックネームは全角で1から10文字までです。",  "mb_maxlength","10");
$form->addRule( "mail_address", "メールアドレスは半角で1から50文字までです。", "rangelength", array(1,50),"client");
$form->addRule( "mail_address2", "メールアドレスは半角で1から50文字までです。", "rangelength", array(1,50),"client");
$form->addRule( "mail_address", "メールアドレスとして不当な入力です。", "email", NULL, "client");
$form->addRule( "mail_address2", "メールアドレスとして不当な入力です。", "email", NULL, "client");
$form->addRule( array("mail_address","mail_address2"),"メールアドレスとメールアドレス確認が一致しません。","compare", NULL, "client");

//エラーメッセージを日本語設定に変更
$form->setRequiredNote('
（※）ご質問事項にすべて回答後、確認画面へとお進み下さい。(<font color="#ff0000">*必須項目</font>)');
$form->setJsWarnings("以下で入力エラーがあります。\n","\n再度、入力項目を確認して下さい");

//出力
if($form->validate()){
    $form->freeze();
    $botton =& $form->addElement("link","back","","$_SERVER[PHP_SELF]","登録画面へ戻る");

}else{
    //送信、セットボタンの生成
    $botton[] =& $form->createElement("submit","send","確認画面へ");
    $botton[] =& $form->createElement("reset","clear","リセット");
    $form->addGroup( $botton, "btn", "");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
    <title>PEAR HTML_QuickForm</title>

</head>
<body>
<?php 
$form->display(); 
print_r($_POST)
?>
</body>
</html>
