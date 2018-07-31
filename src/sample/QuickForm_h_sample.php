<?php

require_once "HTML/QuickForm.php";
//$_POST[f_hidden]="ポスト書き換え";

$_POST[f_hidden]="ポスト書き換え";



//HTML_QuickFormを生成
$form =& new HTML_QuickForm( "test_form","POST","",null,null,true);



//メールアドレス
$form->addElement( "hidden", "f_hidden", "");



    //送信、セットボタンの生成
    $botton[] =& $form->createElement("submit","send","確認画面へ");
    $botton[] =& $form->createElement("reset","clear","リセット");
    $form->addGroup( $botton, "btn", "");

print_r($_POST);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<!--口-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
    <title>PEAR HTML_QuickForm</title>

</head>
<body>
<?php $form->display(); ?>
</body>
</html>
