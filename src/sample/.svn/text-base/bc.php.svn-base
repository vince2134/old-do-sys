<html>
<head><title>消費税計算</title></head>
<body>
<?php

require_once("../../function/function.fnc");


$tax_rate = 5;

if($_POST["keisan"] == "計　算"){

    $coax       = $_POST["coax"];           //金額丸区分
    $tax_rate   = $_POST["tax_rate"];       //消費税率
    $tax_div    = $_POST["tax_div"];        //課税区分
    $tax_franct = $_POST["tax_franct"];     //端数区分
    $price      = $_POST["price"];          //金額
    $num        = $_POST["num"];            //数量

    //金額
    $buy_amount = bcmul($price, $num,2);   

    //金額丸め
    if($coax == '1'){
        $buy_amount = floor($buy_amount);
    }elseif($coax == '2'){
        $buy_amount = round($buy_amount);
    }elseif($coax == '3'){
        $buy_amount = ceil($buy_amount);
    }

    $data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate);

}

if($coax == '1'){
    $coax_name = "切捨て";
    $coax_check1 = "checked";
}elseif($coax == "2"){
    $coax_name = "四捨五入";
    $coax_check2 = "checked";
}elseif($coax == "3"){
    $coax_name = "切上げ";
    $coax_check3 = "checked";
}else{
    $coax_check1 = "checked";
}

if($tax_franct == '1'){
    $tax_franct_name = "切捨て";
    $franct_check1 = "checked";
}elseif($tax_franct == "2"){
    $tax_franct_name = "四捨五入";
    $franct_check2 = "checked";
}elseif($tax_franct == "3"){
    $tax_franct_name = "切上げ";
    $franct_check3 = "checked";
}else{
    $franct_check1 = "checked";
}


if($tax_div == '1'){
    $tax_div_name = "外税";
    $div_check1 = "checked";
}elseif($tax_div == "2"){
    $tax_div_name = "内税";
    $div_check2 = "checked";
}elseif($tax_div == "3"){
    $tax_div_name = "非課税";
    $div_check3 = "checked";
}else{
    $div_check1 = "checked";
}

print "課税区分：".$tax_div_name."<br>";
print "丸め区分：".$coax_name."<br>";
print "端数区分：".$tax_franct_name."<p>";

print "<hr>";
print "税抜金額　：　".$data[0]."　　消費税額　：　".$data[1]."　　税込金額　：　".$data[2]."<br>";
print "<hr>";
?>
<form method="POST" action="#">
<table border="0">
    <tr>
        <td>【消費税率】　　　：</td>
        <td><input type="text" value="<? print $tax_rate?>" name="tax_rate"></td>
    </tr>
    <tr>
        <td>【単価】　　　　　　：</td>
        <td><input type="text" value="<?print $price?>" name="price"></td>
    </tr>
    <tr>
        <td>【数量】　　　　　　：</td>
        <td><input type="text" value="<?print $num?>" name="num"></td>
    </tr>
    <tr>
        <td>【課税区分】　　　：</td>
        <td>
            外税<input type="radio" name="tax_div" value="1" <? print $div_check1?>>
            内税<input type="radio" name="tax_div" value="2" <? print $div_check2?>>
            非課税<input type="radio" name="tax_div" value="3" <? print $div_check3?>>
        </td>
    </tr>
    <tr>
        <td>【金額丸め区分】：</td>
        <td>
            切捨て<input type="radio" name="coax" value="1" <? print $coax_check1?>>
            四捨五入<input type="radio" name="coax" value="2"<? print $coax_check2?> >
            切り上げ<input type="radio" name="coax" value="3" <? print $coax_check3?>>
        </td>
    </tr>
    <tr>
        <td>【端数区分】　　　：</td>
        <td>
            切捨て<input type="radio" name="tax_franct" value="1" checked <? print $franct_check1?>>
            四捨五入<input type="radio" name="tax_franct" value="2" <? print $franct_check2?>>
            切り上げ<input type="radio" name="tax_franct" value="3" <? print $franct_check3?>>
        </td>
    </tr>
    <tr>
        <td colspan="2" height="50" align="center">
            <input type="submit" value="計　算" name="keisan">
        </td>
    </tr>
</table>
</form>

</body>
</html>
    




