<HTML>
 <HEAD>
 <TITLE>Do.sys2007 URL�ѹ��Τ��Τ餻</TITLE>
 <SCRIPT LANGUAGE="javascript">
 <!--
function Count_Time() {
        //�ƥ����Ȥ��ͤ����
        now = frm.txt_cnt.value;
        if ( now == "" ) {
            //�������
            now = 10;
        } else {
            //������ȥ�����
            now = parseInt(now);
            now = now - 1;
        }
        
        //�ƥ����Ȥ��ͤ�0�ξ��        
        if ( now == 0 ) {
            //��������
            location.href = "https://125.206.219.234/demo/amenity/src/login.php";
        } else {
            //�����ÿ���ɽ��
            document.frm.txt_cnt.value  = now;
            //1����˴ؿ����ɹ���
            setTimeout("Count_Time()",1000);
        }

}
 //-->   
 </SCRIPT>
 </HEAD>

<BODY onLoad="javascript:Count_Time();">
<CENTER>
<br>
<b>2007ǯ10��22����� <font face="HG��īE">Do.sys2007</font> ��URL���ѹ����ޤ�����</b>
<br>
<br>
<form name="frm">
�֥å��ޡ�����������ϡ��ʲ�URL�ˤ��ѹ��������ޤ��褦���ꤤ�����夲�ޤ���<br>
<a href="https://125.206.219.234/demo/amenity/src/login.php">
https://125.206.219.234/demo/amenity/src/login.php</a><br>
<br>
<br>
<br>
�� <input type="text" name="txt_cnt" size="1" style="color: #525552; border: #ffffff 2px solid;">�ø�˼�ư�ǥڡ��������ܤ��ޤ���<br><br>
</form>
</BODY>
</HTML>

