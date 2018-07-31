<HTML>
 <HEAD>
 <TITLE>Do.sys2007 URL変更のお知らせ</TITLE>
 <SCRIPT LANGUAGE="javascript">
 <!--
function Count_Time() {
        //テキストの値を取得
        now = frm.txt_cnt.value;
        if ( now == "" ) {
            //初期設定
            now = 10;
        } else {
            //カウントダウン
            now = parseInt(now);
            now = now - 1;
        }
        
        //テキストの値が0の場合        
        if ( now == 0 ) {
            //画面遷移
            location.href = "https://125.206.219.234/demo/amenity/src/login.php";
        } else {
            //今の秒数を表示
            document.frm.txt_cnt.value  = now;
            //1秒毎に関数を読込む
            setTimeout("Count_Time()",1000);
        }

}
 //-->   
 </SCRIPT>
 </HEAD>

<BODY onLoad="javascript:Count_Time();">
<CENTER>
<br>
<b>2007年10月22日より <font face="HG明朝E">Do.sys2007</font> はURLが変更しました。</b>
<br>
<br>
<form name="frm">
ブックマーク、リンク等は、以下URLにご変更下さいますようお願い申し上げます。<br>
<a href="https://125.206.219.234/demo/amenity/src/login.php">
https://125.206.219.234/demo/amenity/src/login.php</a><br>
<br>
<br>
<br>
※ <input type="text" name="txt_cnt" size="1" style="color: #525552; border: #ffffff 2px solid;">秒後に自動でページが遷移します。<br><br>
</form>
</BODY>
</HTML>

