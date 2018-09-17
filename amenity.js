/**
 * @fileoverview ����˥ƥ�����JavaScript
 *
 * ��������롼��
 * ����¸�δؿ�̾�Ȥä�������
 * ���ե�����򳫤����ޤ�Υ�ʤ���������
 * �����顼��Ф����ޤ�Υ�ʤ���������
 * ���������Τʤ��ؿ��Ϥ��줾���PHP������ץ���ʤ⤷������js�ե�����ˤ�
 * ���ۤȤ�ɽ�����Ʊ���ʤΤˡ�2�Ȥ�3�Ȥ�̾����Ĥ��ƴؿ������䤷�ƥե������Ť����ʤ�
 *   �ʴؿ�¦���ѹ��ǺѤ���ϡ��ؿ�¦���б������
 * ���Ȥ�ʤ��ʤä��ؿ��Ͼä��ʥ����ȥ����Ȥ����
 *
 *
 * @author
 * @version
 *
 */

/*****************���ʥ��롼������*********************************/
//�ɲå�󥯲�������
function insert_row(hidden){
    //�ɲå�󥯤������줿
    document.dateForm.elements[hidden].value = true;
    document.dateForm.target="_self";
    document.dateForm.submit();
}

//�ѹ���󥯲�������
function update_row(str_check,hidden,row){
    document.dateForm.elements[hidden].value = row;
    document.dateForm.target="_self";
    document.dateForm.submit();
}

/****************************��������*******************************/

//ǯ������������ƥ����Ȥμ�ư�ե���������ư
//�����ʥե�����,���롼��̾,��ư��,��ư��,��ư�輱���ֹ��
function move_text(me,main,name,next,num){

    //ǯ����
    if(num==1){
        var Y = main+"["+name+"]";
        var M = main+"["+next+"]";

        len = me.elements[Y].value.length;
        if( 4==len){
            me.elements[M].focus();
        }
    //���
    }else if(num==2){
        var M = main+"["+name+"]";
        var W = main+"["+next+"]";

        len = me.elements[M].value.length;
        if( 2==len){
            me.elements[W].focus();
        }
    //��������
    }else if(num==3){
        var W = main+"["+name+"]";
        var D = main+"["+next+"]";
        len = me.elements[W].value.length;
        if( 1==len){
            me.elements[D].focus();
        }
    }
}

//���դ������������
function date_week(me,y_name,m_name,d_name,week){
    myTbl     = new Array("��","��","��","��","��","��","��");
    var y = me.elements[y_name].value;
    var m = me.elements[m_name].value;
    var d = me.elements[d_name].value;
   
    //ǯ������������Ƚ�� 
    if(y != "" && m != "" && d != ""){
        myD       = new Date(y,m-1,d);
        myDay     = myD.getDay();
        myweek   = myTbl[myDay];

        if(myweek != undefined){
            me.elements[week].value = myweek;
        }
    }else{
        me.elements[week].value = "";
    }
}

/**
 * ��������ѹ���������������ѹ�����
 * �����Υե�����̾��
 *   ǯ�����Υե������[y][m][d]��AddGroup���Ƥ�������
 * 
 * @param   {String}    source_date     ���Υե�����̾
 * @param   {String}    change_date     �ѹ������ե�����̾
 * 
 */
function Claim_Day_Change(source_date, change_date){

    SY = source_date + "[y]";
    SM = source_date + "[m]";
    SD = source_date + "[d]";
    CY = change_date + "[y]";
    CM = change_date + "[m]";
    CD = change_date + "[d]";

    if(document.dateForm.elements[SY].value != "" && document.dateForm.elements[SM].value != "" && document.dateForm.elements[SD].value != ""){
        document.dateForm.elements[CY].value = document.dateForm.elements[SY].value;
        document.dateForm.elements[CM].value = document.dateForm.elements[SM].value;
        document.dateForm.elements[CD].value = document.dateForm.elements[SD].value;
    }

    return true;

}


/**********************TOP��SUB��˥塼����***************************/

//�ȥåץ�˥塼������å����줿���ϡ����å����������
//���֥�˥塼������å����줿���ϡ������˥��֥������Ȥ�"id"�����ꤹ�뤳�Ȥǡ�
//�ĥ꡼��¤��˥塼�γ��Ĥ�Ԥ�
//�����ʥ�˥塼����,������FC����,���֥�˥塼̾,top��sub���̡�
function TS_Menu(menu,where_menu,tName,ts_menu) {
    //������FC����
    if(where_menu == 'head'){
        /******����******/
        switch (menu){
            case 'sale':
                data_menu = new Array("�������","�����","�������","�������","���Ӵ���");
                break;
            case 'buy':
                data_menu = new Array("ȯ�����","�������","��ʧ����","���Ӵ���");
                break;
            case 'stock':
                data_menu = new Array("�߸˼��","ê������");
                break;
            case 'renew':
                data_menu = new Array("��������");
                break;
            case 'system':
                //data_menu = new Array("�ޥ�������","�����ƥ�����");
                data_menu = new Array("�ޥ�������","Ģɼ����","�����ƥ�����");
                break;
            case 'analysis':
                data_menu = new Array("���׾���","��������������","CSV����");
                break;
            default:
        }
    }else{
    /******FC******/
        switch (menu){
            case 'sale':
                data_menu = new Array("ͽ����","�����","�������","�������","���Ӵ���");
                break;
            case 'buy':
                data_menu = new Array("ȯ�����","�������","��ʧ����","���Ӵ���");
                break;
            case 'stock':
                data_menu = new Array("�߸˼��","ê������");
                break;
            case 'renew':
                data_menu = new Array("��������");
                break;
            case 'system':
                //data_menu = new Array("�ޥ�������","�����ƥ�����");
                data_menu = new Array("�ޥ�������","Ģɼ����","�����ƥ�����");
                break;
            case 'analysis':
                data_menu = new Array("���׾���","CSV����");
                break;
            default:
        }
    }
    //ͭ�����¤η׻��򤷤ޤ���
    var today = new Date();
    today.setHours(today.getHours() + 1);

    //TOP��SUB��˥塼Ƚ��
    if(ts_menu == "top"){
        //TopMenu����
        //��˥塼���ܿ�ʬȽ��
        for(var i=0;i<data_menu.length;i++){
            var j = i + 1;
            var str = "history"+j;
            var str2 = "history_flg"+j;

            //Ÿ�����줿��˥塼�ϲ���
            if(tName == data_menu[i]){
                //Ÿ��������˥塼̾
                document.cookie = str + "=" + j + "; expires=" + today.toGMTString() + ", path=/";
                //Ÿ�����Ĥ��뼱�̥ե饰
                document.cookie = str2 + "=" + 'true' + "; expires=" + today.toGMTString() + ", path=/";
            }
        }
    }else{
        //SubMenu����
        //�������륪�֥������ȼ���
        tMenu = document.getElementById(tName).style;
        imgName = tName+'Img';

        //���֥�˥塼������å����줿��
        if(tMenu.display=='none'){
            //��˥塼��Ÿ������
            tMenu.display='block';
            document.getElementById(imgName).src='../../../image/minus.png';
            //��˥塼���ܿ�ʬȽ��
            for(var i=0;i<data_menu.length;i++){
                var j = i + 1;
                var str = "history"+j;
                var str2 = "history_flg"+j;
                //Ÿ�����줿��˥塼�ϲ���
                if(tName == data_menu[i]){
                    //Ÿ��������˥塼̾
                    document.cookie = str + "=" + j + "; expires=" + today.toGMTString() + ", path=/";
                    //Ÿ�����Ĥ��뼱�̥ե饰
                    document.cookie = str2 + "=" + 'true' + "; expires=" + today.toGMTString() + ", path=/";
                }
            }                                      
        }else{
            //��˥塼���Ĥ���
            tMenu.display='none';
            document.getElementById(imgName).src='../../../image/plus.png';
            for(var i=0;i<data_menu.length;i++){
                var j = i + 1;
                var str = "history"+j;
                var str2 = "history_flg"+j;
                //�Ĥ���줿��˥塼�ϲ���
                if(tName == data_menu[i]){
                    document.cookie = str + "=" + j + "; expires=" + today.toGMTString() + ", path=/";
                    //Ÿ�����Ĥ��뼱�̥ե饰
                    document.cookie = str2 + "=" + 'false' + "; expires=" + today.toGMTString() + ", path=/";
                }
            }
        }
    }                       
}

//���֥�˥塼������å����줿��硢���å������������
function SubMenu2(tName) {
    document.dateForm.action=tName;
    document.dateForm.submit();
}

//��˥塼�ο����դ���Τˡ���ե��顼��ȤФ�
function Referer(tName) {
//  document.referer.action=tName;
//    document.referer.submit();
    location.href(tName);
}

//���å������
function deleteCookie(){
    today = new Date;
    today.setHours(today.getHours() - 4); //4������������
    for(var i=1;i<6;i++){
        var str = "history"+i;
        var str2 = "history_flg"+i;
        document.cookie = str + "= taka; expires=" + today.toGMTString() + ", path=/";
        document.cookie = str2 + "= taka; expires=" + today.toGMTString() + ", path=/";
    }
}

/*********************����������ɽ��************************/
//��Ͽ/�ѹ�����������ɽ��
function Win_open(str_check,next){
    // ��ǧ����������ɽ��
    res = window.confirm(str_check+"\n��������Ǥ�����");
    // ����ʬ��
    if (res == true){
        document.dateForm.action=next;
        document.dateForm.target="_blank";
        document.dateForm.submit();
        return true;
    }else{
        return false;
    }
}

// ��Ͽ/�ѹ�����������ɽ��
function Dialogue(str_check,next){
    // ��ǧ����������ɽ��
    res = window.confirm(str_check+"\n��������Ǥ�����");
    // ����ʬ��
    if (res == true){
        if(str_check=="��Ͽ��ȯ�����ȯ�Ԥ��ޤ���"){
            window.open('../../head/buy/1-3-105.php','_blank','');
        }else{
            document.dateForm.action=next;
            document.dateForm.target="_self";
            document.dateForm.submit();
        }
        return true;
    }else{
        return false;
    }
}

// ��Ͽ/�ѹ�����������ɽ��
function Dialogue2(str_check,next){
    // ��ǧ����������ɽ��
    res = window.confirm(str_check+"\n��������Ǥ�����");
    // ����ʬ��
    if (res == true){
        if(str_check=="��Ͽ��ȯ�����ȯ�Ԥ��ޤ���"){
            window.open('2-3-105.php','_blank','');
        }else if(str_check=="��§�������ꤷ�ޤ���"){
            window.close();
        }else{
            document.dateForm.action=next;
            document.dateForm.submit();
        }
        return true;
    }else{
        return false;
    }
}

function Dialogue3(str_check){
    // ��ǧ����������ɽ��
    res = window.confirm(str_check+"\n��������Ǥ�����");
    if (res == true){
        window.close();
    }else{
        return false;
    }
}

function Dialogue4(str_check){
    if(window.confirm(str_check+"\n��������Ǥ�����")==true){
        return true;
    }else{
        return false;
    }
}
//��󥯤�submit����
function dialogue5(str_check){

    if(window.confirm(str_check+"\n��������Ǥ�����")==true){
        //POST�������������
        document.dateForm.submit();
        return true;
    }else{
        return false;
    }

}

//����ѥ���������ɽ��
function Dialogue_1(str_check, row, hidden){
    // ��ǧ����������ɽ��
    res = window.confirm(str_check+"\n��������Ǥ�����");
    // ����ʬ��
    if (res == true){
        var hdn = hidden;
        var next = '#';
        document.dateForm.elements[hdn].value = row;
        //Ʊ��������ɥ������ܤ���
        document.dateForm.target="_self";
        //�����̤����ܤ���
        document.dateForm.action=next;
        //POST�������������
        document.dateForm.submit();
             return true;
    }else{
             return false;
        }
}

function Dialogue_2(str_check, next, row, hidden){
    // ��ǧ����������ɽ��
    res = window.confirm(str_check+"\n��������Ǥ�����");
    // ����ʬ��
    if (res == true){
        var hdn = hidden;
        document.dateForm.elements[hdn].value = row;
        //Ʊ��������ɥ������ܤ���
        document.dateForm.target="_self";
        //�����̤����ܤ���
        document.dateForm.action=next;
        //POST�������������
        document.dateForm.submit();
             return true;
    }else{
             return false;
        }
}

//�����󥯥���������
function Dialogue_3(str_check, row, hidden, row_num){
    //��ǧ����������ɽ��
    res = window.confirm(str_check+"��������Ǥ�����");
    //����ʬ��
    if (res == true){
        var hdn = hidden;
        //������ķ�������
        var next = '#'+row_num;
        document.dateForm.elements[hdn].value = row;
        //Ʊ��������ɥ������ܤ���
        document.dateForm.target="_self";
        //���ܤ���
        document.dateForm.action=next;
        //POST�������������
        document.dateForm.submit();
        return true;
    }
}

//�������ѥ���������ɽ��
function Dialogue_4(str_check, row, hidden1, date, hidden2){
    // ��ǧ����������ɽ��
    res = window.confirm(str_check+"\n��������Ǥ�����");
    // ����ʬ��
    if (res == true){
        var hdn1 = hidden1;
        var hdn2 = hidden2;
        var next = '#';
        document.dateForm.elements[hdn1].value = row;
        document.dateForm.elements[hdn2].value = date;
        //Ʊ��������ɥ������ܤ���
        document.dateForm.target="_self";
        //�����̤����ܤ���
        document.dateForm.action=next;
        //POST�������������
        document.dateForm.submit();
             return true;
    }else{
             return false;
        }
}

//�������ѥ���������ɽ��
function Dialogue_5(str_check, row, hidden1, date, hidden2, next){
    // ��ǧ����������ɽ��
    res = window.confirm(str_check+"\n��������Ǥ�����");
    // ����ʬ��
    if (res == true){
        var hdn1 = hidden1;
        var hdn2 = hidden2;
        document.dateForm.elements[hdn1].value = row;
        document.dateForm.elements[hdn2].value = date;
        //Ʊ��������ɥ������ܤ���
        document.dateForm.target="_self";
        //�����̤����ܤ���
        document.dateForm.action=next;
        //POST�������������
        document.dateForm.submit();
             return true;
    }else{
             return false;
    }
}

//�ܥ����ѥ���������ɽ��
//�ե����������ˡ����ߤ����դ�ɽ������
function onForm_today(which,me,form_y,form_m,form_d){
    if (document.all || document.getElementById){
        which.style.backgroundColor="#FDFD66"
    }
    today       = new Date();
    Year    = today.getYear();
    Month   = today.getMonth()+1;
    Day     = today.getDate();
    var Y = form_y;
    var M = form_m;
    var D = form_d;
    //�������Ϥ���Ƥ��뤫
    if(me.elements[Y].value == "" && me.elements[M].value == "" && me.elements[D].value == ""){
        me.elements[Y].value = Year;
        me.elements[M].value = Month;
        me.elements[D].value = Day;
        //���ʤ�0���դ���
        if(me.elements[M].value <= 9){
                me.elements[M].value = "0" + Month;
        }
        if(me.elements[D].value <= 9){
                me.elements[D].value = "0" + Day;
        }
    }
}


// �ե����������˻����������������դ�ɽ��
function Resrv_Form_NextToday(which, me, form, form_y, form_m, form_d, form_base, form_base_y, form_base_m, form_base_d){

    // �ե����������ϥե�����ο����Ѥ���
    if (document.all || document.getElementById){
        which.style.backgroundColor="#FDFD66"
    }


    //�����
    var Base_Y = form_base+"["+form_base_y+"]";
    var Base_M = form_base+"["+form_base_m+"]";
    var Base_D = form_base+"["+form_base_d+"]";
    var yy = document.dateForm.elements[Base_Y].value;
    var mm = document.dateForm.elements[Base_M].value;
    var dd = document.dateForm.elements[Base_D].value;
    mm = mm-1; //���0��11�ʤΤǷ������碌��

    //����������Ϥ���Ƥ��ʤ����
    if (yy == "" || mm == "" || dd == ""){
        return;
    }

    today = new Date(yy,mm,dd);
    today.setDate (today.getDate () + 1); // 1���������
    Year  = today.getYear();
    Month = today.getMonth()+1;
    Day   = today.getDate();

    //�ͤ��᤹�ե�����̾
    var Y = form+"["+form_y+"]";
    var M = form+"["+form_m+"]";
    var D = form+"["+form_d+"]";


    // ���Ͼ��֤ʤ������䴰
    if (me.elements[Y].value == "" && me.elements[M].value == "" && me.elements[D].value == ""){
    
        //�����Ǥʤ����դξ���""��ɽ��
        if(0<Year && Year<10000){
            me.elements[Y].value = Year;
        }else{
            me.elements[Y].value = "";
        }

        if(0<Month && Month<13){
            me.elements[M].value = Month;

            // 1��ʤ�0���
            if (me.elements[M].value <= 9){
                me.elements[M].value = "0" + Month;
            }            

        }else{
            me.elements[M].value = "";
        }
        
        if(0<Day && Day<32){
            me.elements[D].value = Day;

            // 1��ʤ�0���
            if (me.elements[D].value <= 9){
                me.elements[D].value = "0" + Day;
            }

        }else{
            me.elements[D].value = "";
        }


    }

}


//�ե����������ˡ����ߤ�ǯ���ɽ������
function onForm_today2(which,me,form_y,form_m){
    if (document.all || document.getElementById){
        which.style.backgroundColor="#FDFD66"
    }
    today       = new Date();
    Year    = today.getYear();
    Month   = today.getMonth()+1;

    var Y = form_y;
    var M = form_m;
    
    //�������Ϥ���Ƥ��뤫
    if(me.elements[Y].value == "" && me.elements[M].value == ""){
        me.elements[Y].value = Year;
        me.elements[M].value = Month;
    
        //���ʤ�0���դ���
        if(me.elements[M].value <= 9){
                me.elements[M].value = "0" + Month;
        }
    }
}

/*********************��ư�ե�������***********************/


//�ե����������˽���ͤ�ɽ��
//������form���֥������ȡ����ܡ��ե���������ưʸ������
function Default_focus(me,name,next,length){
    len = name.value.length;
    if(me.elements[next].value == "")
    {
        me.elements[next].value = "00";
    }
    if(length==len){
        me.elements[next].focus();
    }
}

//�ե���������ư
function changeText(me,name,next,length,val){
    var F1 = name;
    var F2 = next;
    
    if(val != undefined)
    {
        if(me.elements[F2].value == "")
        {
            me.elements[F2].value = val;
        }
    }
    len = me.elements[F1].value.length;
    if(length==len){
        me.elements[F2].focus();
    }
}

//6-4��ƥ����Ȥμ�ư�ե���������ư
function changeText1(me,num){
    var S = "f_code_a"+num+"[f_text6]";
    var E = "f_code_a"+num+"[f_text4]";
    len = me.elements[S].value.length;
    if(me.elements[E].value == "")
    {
        me.elements[E].value = "0000";
    }
    if( 6==len){
        me.elements[E].focus();
    }
}


//6-3��ƥ����Ȥμ�ư�ե���������ư
function changeText2(me,num){
    var S = "f_code_b"+num+"[f_text6]";
    var E = "f_code_b"+num+"[f_text3]";
    len = me.elements[S].value.length;
    if( 6==len){
        me.elements[E].focus();
    }
}

//4ʸ��-2ʸ��-2ʸ���μ�ư�ե���������ư
function changeText3(me,num){
    var Y = "f_date_a"+num+"[y_input]";
    var M = "f_date_a"+num+"[m_input]";
    len = me.elements[Y].value.length;
    if( 4==len){
        me.elements[M].focus();
    }
}
function changeText4(me,num){
    var M = "f_date_a"+num+"[m_input]";
    var D = "f_date_a"+num+"[d_input]";
    len = me.elements[M].value.length;
    if( 2<=len){
        me.elements[D].focus();
    }
}


//4ʸ��-2ʸ��-2ʸ����4ʸ��-2ʸ��-2ʸ���μ�ư�ե���������ư
function changeText5(me,num){
    var Y = "f_date_b"+num+"[y_start]";
    var M = "f_date_b"+num+"[m_start]";
    len = me.elements[Y].value.length;
    if( 4==len){
        me.elements[M].focus();
    }
}
function changeText6(me,num){
    var M = "f_date_b"+num+"[m_start]";
    var D = "f_date_b"+num+"[d_start]";
    len = me.elements[M].value.length;
    if( 2<=len){
        me.elements[D].focus();
    }
}
function changeText7(me,num){
    var D = "f_date_b"+num+"[d_start]";
    var Y = "f_date_b"+num+"[y_end]";
    len = me.elements[D].value.length;
    if( 2<=len){
        me.elements[Y].focus();
    }
}
function changeText8(me,num){
    var Y = "f_date_b"+num+"[y_end]";
    var M = "f_date_b"+num+"[m_end]";
    len = me.elements[Y].value.length;
    if( 4==len){
        me.elements[M].focus();
    }
}
function changeText9(me,num){
    var M = "f_date_b"+num+"[m_end]";
    var D = "f_date_b"+num+"[d_end]";
    len = me.elements[M].value.length;
    if( 2<=len){
        me.elements[D].focus();
    }
}

function changeText18(me,num){
    var M = "f_time_a"+num+"[h_input]";
    var D = "f_time_a"+num+"[m_input]";
    len = me.elements[M].value.length;
    if( 2==len){
        me.elements[D].focus();
    }
}


//9ʸ��.2ʸ���μ�ư�ե���������ư
function changeText10(me,num){
    var S = "f_code_c"+num+"[f_text9]";
    var E = "f_code_c"+num+"[f_text2]";
    len = me.elements[S].value.length;
    if(me.elements[E].value == "")
    {
        me.elements[E].value = "00";
    }
    if( 9==len){
        me.elements[E].focus();
    }
}


//3ʸ��-4ʸ���μ�ư�ե���������ư
function changeText11(me,num){
    var S = "f_code_d"+num+"[f_text3]";
    var E = "f_code_d"+num+"[f_text4]";
    len = me.elements[S].value.length;
    if( 3==len){
        me.elements[E].focus();
    }
}

//9ʸ��-9ʸ���μ�ư�ե���������ư
function changeText12(me,num){
    var S = "f_code_e"+num+"[f_text9_1]";
    var E = "f_code_e"+num+"[f_text9_2]";
    len = me.elements[S].value.length;
    if( 9==len){
        me.elements[E].focus();
    }
}

//4-2��ƥ����Ȥμ�ư�ե���������ư
function changeText13(me,num){
    var Y = "f_date_c"+num+"[y_input]";
    var M = "f_date_c"+num+"[m_input]";
    len = me.elements[Y].value.length;
    if( 4==len){
        me.elements[M].focus();
    }
}

//2-2��ƥ����Ȥμ�ư�ե���������ư
function changeText14(me,num){
    var S = "f_code_f"+num+"[f_text2_1]";
    var E = "f_code_f"+num+"[f_text2_2]";
    len = me.elements[S].value.length;
    if( 2==len){
        me.elements[E].focus();
    }
}

//4ʸ��-2ʸ����4ʸ��-2ʸ���μ�ư�ե���������ư
function changeText15(me,num){
    var Y = "f_date_d"+num+"[y_start]";
    var M = "f_date_d"+num+"[m_start]";
    len = me.elements[Y].value.length;
    if( 4==len){
        me.elements[M].focus();
    }
}
function changeText16(me,num){
    var M = "f_date_d"+num+"[m_start]";
    var Y = "f_date_d"+num+"[y_end]";
    len = me.elements[M].value.length;
    if( 2<=len){
        me.elements[Y].focus();
    }
}

function changeText17(me,num){
    var Y = "f_date_d"+num+"[y_end]";
    var M = "f_date_d"+num+"[m_end]";
    len = me.elements[Y].value.length;
    if( 4==len){
        me.elements[M].focus();
    }
}

//4-4��ƥ����Ȥμ�ư�ե���������ư
function changeText18(me,num){
    var S = "f_code_g"+num+"[f_text4_1]";
    var E = "f_code_g"+num+"[f_text4_2]";
    len = me.elements[S].value.length;
    if( 4==len){
        me.elements[E].focus();
    }
}

//ǯ��μ�ư�ե���������ư�ʥ��롼�ײ����Ƥ��ʤ���
function date_text(me,num){
    var S = "y_input"+num;
    var E = "m_input"+num;
    len = me.elements[S].value.length;
    if( 4==len){
        me.elements[E].focus();
    }
}

function changeText_staff(me){
    var code1 = "f_staff[code1]";
    var code2 = "f_staff[code2]";
    len = me.elements[code1].value.length;
    if(me.elements[code2].value == "")
    {
        me.elements[code2].value = "000";
    }
    if( 6==len){
        me.elements[code2].focus();
    }
}

function changeText_customer(me,num){
    if(num == undefined){
        var code1 = "f_customer[code1]";
        var code2 = "f_customer[code2]";
    }else{
        var code1 = "f_customer"+num+"[code1]";
        var code2 = "f_customer"+num+"[code2]";
    }
    len = me.elements[code1].value.length;
    if(me.elements[code2].value == "")
    {
        me.elements[code2].value = "0000";
    }
    if( 6==len){
        me.elements[code2].focus();
    }
}

function changeText_shop(me){
    var code1 = "f_shop[code1]";
    var code2 = "f_shop[code2]";
    len = me.elements[code1].value.length;
    if(me.elements[code2].value == "")
    {
        me.elements[code2].value = "0000";
    }
    if( 6==len){
        me.elements[code2].focus();
    }
}

//9ʸ��.2ʸ���μ�ư�ե���������ư
function input_price(me,num){
    var S = "form_price["+num+"][i]";
    var E = "form_price["+num+"][d]";
    len = me.elements[S].value.length;
    if(me.elements[E].value == "")
    {
        me.elements[E].value = "00";
    }
    if( 9==len){
        me.elements[E].focus();
    }
}

//4ʸ��-2ʸ��-2ʸ���μ�ư�ե���������ư
function changedate1(me,num){
        var Y = "form_rank_date["+num+"][y]";
        var M = "form_rank_date["+num+"][m]";
        len = me.elements[Y].value.length;
        if( 4==len){
                me.elements[M].focus();
        }
}
function changedate2(me,num){
        var M = "form_rank_date["+num+"][m]";
        var D = "form_rank_date["+num+"][d]";
        le = me.elements[M].value.length;
        if( 2<=len){
                me.elements[D].focus();
        }
}

// ��ư�ե���������ư
function Nextfocus(me, form, form1, form2, num){

    var S = form+"["+form1+"]";
    var E = form+"["+form2+"]";
    len = me.elements[S].value.length;
    if(num==len){
        me.elements[E].focus();
        me.elements[E].select();
    }

}

// ��ư�ե���������ư
// ��ư��ե�����˥ƥ������䴰��Ǥ�ա�
// ��ư��ƥ����Ȥ�����
function Next_Focus(me, form, form1, form2, num, val){

    var F1 = form+"["+form1+"]";
    var F2 = form+"["+form2+"]";
    if (val != undefined){
        if (me.elements[F2].value == ""){
            me.elements[F2].value = val;
        }
    }
    len = me.elements[F1].value.length;
    if (num == len){
        me.elements[F2].focus();
        me.elements[F2].select();
    }

}

//�黻��̤θ�����ʤ���
function trimFixed(a) {
    var x = "" + a;
    var m = 0;
    var e = x.length;
    for (var i = 0; i < x.length; i++) {
        var c = x.substring(i, i + 1);
        if (c >= "0" && c <= "9") {
            if (m == 0 && c == "0") {
            } else {
                m++;
            }
        } else if (c == " " || c == "+" || c == "-" || c == ".") {
        } else if (c == "E" || c == "e") {
            e = i;
            break;
        } else {
            return a;
        }
    }

    var b = 1.0 / 3.0;
    var y = "" + b;
    var q = y.indexOf(".");
    var n;
    if (q >= 0) {
        n = y.length - (q + 1);
    } else {
        return a;
    }

    if (m < n) {
        return a;
    }

    var p = x.indexOf(".");
    if (p == -1) {
        return a;
    }
    var w = " ";
    for (var i = e - (m - n) - 1; i >= p + 1; i--) {
        var c = x.substring(i, i + 1);
        if (i == e - (m - n) - 1) {
            continue;
        }
        if (i == e - (m - n) - 2) {
            if (c == "0" || c == "9") {
                w = c;
                continue;
            } else {
                return a;
            }
        }
        if (c != w) {
            if (w == "0") {
                var z = (x.substring(0, i + 1) + x.substring(e, x.length)) - 0;
                return z;
            } else if (w == "9") {
                var z = (x.substring(0, i) + ("" + ((c - 0) + 1)) + x.substring(e, x.length)) - 0;
                return z;
            } else {
                return a;
            }
        }
    }
    if (w == "0") {
        var z = (x.substring(0, p) + x.substring(e, x.length)) - 0;
        return z;
    } else if (w == "9") {
        var z = x.substring(0, p) - 0;
        var f;
        if (a > 0) {
            f = 1;
        } else if (a < 0) {
            f = -1;
        } else {
            return a;
        }
        var r = (("" + (z + f)) + x.substring(e, x.length)) - 0;
        return r;
    } else {
        return a;
    }
}

//�����򥫥�ޤǶ��ڤ�
function myFormatNumber(x) { 
    var s = "" + x; //ʸ���󷿤��Ѵ����롣
    var p = s.indexOf("."); // �������ΰ��֤�0���ꥸ��ǵ��롣
    if (p < 0) { // �����������Ĥ���ʤ��ä���
        p = s.length; // ����Ū�ʾ������ΰ��֤Ȥ���
    }
    var r = s.substring(p, s.length); // �������η�Ⱦ�������걦¦��ʸ����
    for (var i = 0; i < p; i++) { // (10 ^ i) �ΰ̤ˤĤ���
        var c = s.substring(p - 1 - i, p - 1 - i + 1); // (10 ^ i) �ΰ̤ΤҤȤĤη�ο�����
        if (c < "0" || c > "9") { // �����ʳ��Τ��(���ʤ�)�����Ĥ��ä�
            r = s.substring(0, p - i) + r; // �Ĥ�������ղä���
            break;
        }
        if (i > 0 && i % 3 == 0) { // 3 �头�ȡ����������Ͻ���
            r = "," + r; // ����ޤ��ղä���
        }
        r = c + r; // ���������ɲä��롣
    }
    return r; // ��Ǥ� "95,839,285,734.3245"
}

//��ȴ���������ǡ��ǹ��׻�
function Tax_Cal(goods_id,order_num,price_i,price_d,coax,buy_amount,tax_franct,tax_amount,buy_price){
    var HG = goods_id;
    var ON = order_num;
    var PI = price_i;
    var PD = price_d;
    var BA = buy_amount;
    var TA = tax_amount;
    var BP = buy_price;

    //hidden�ξ���ID�����뤫
    if(document.dateForm.elements[HG].value != ""){
        document.dateForm.elements[BA].value = document.dateForm.elements[ON].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
        //�ڼΤƤξ��
        if(coax == '1'){
            document.dateForm.elements[BA].value = Math.floor(document.dateForm.elements[BA].value * 100)/100;
        //�ͼθ����ξ��
        }else if(coax == '2'){
            document.dateForm.elements[BA].value = Math.round(document.dateForm.elements[BA].value * 100)/100;
        //�ھ夲�ξ��
        }else if(coax == '3'){
            document.dateForm.elements[BA].value = Math.ceil(document.dateForm.elements[BA].value * 100)/100;
        }
        
        //�������ʲ����ά���ʤ�(�����)
        decimal = document.dateForm.elements[BA].value.indexOf(".",0); 
        len = document.dateForm.elements[BA].value.length;
        if(decimal == -1){
            document.dateForm.elements[BA].value = document.dateForm.elements[BA].value+'.00';
        }else if(len == decimal+2){
            document.dateForm.elements[BA].value = document.dateForm.elements[BA].value+'0';
        }
        
        //�����Ǥʤ����϶����֤�
        if(isNaN(document.dateForm.elements[BA].value) == true){
            document.dateForm.elements[BA].value = "";
        }
        
        document.dateForm.elements[TA].value = eval(document.dateForm.elements[ON].value * (eval(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value))) * 0.05;
        //�ڼΤƤξ��
        if(tax_franct == '1'){
            document.dateForm.elements[TA].value = Math.floor(document.dateForm.elements[TA].value * 100)/100;
        //�ͼθ����ξ��
        }else if(tax_franct == '2'){
            document.dateForm.elements[TA].value = Math.round(document.dateForm.elements[TA].value * 100)/100;
        //�ھ夲�ξ��
        }else if(tax_franct == '3'){
            document.dateForm.elements[TA].value = Math.ceil(document.dateForm.elements[TA].value * 100)/100;
        }
        
        //�������ʲ����ά���ʤ�(�����)
        decimal = document.dateForm.elements[TA].value.indexOf(".",0); 
        len = document.dateForm.elements[TA].value.length;
        if(decimal == -1){
            document.dateForm.elements[TA].value = document.dateForm.elements[TA].value+'.00';
        }else if(len == decimal+2){
            document.dateForm.elements[TA].value = document.dateForm.elements[TA].value+'0';
        }
        
        //�����Ǥʤ����϶����֤�
        if(isNaN(document.dateForm.elements[TA].value) == true){
            document.dateForm.elements[TA].value = "";
        }
        
        document.dateForm.elements[BP].value = eval(document.dateForm.elements[BA].value) + eval(document.dateForm.elements[TA].value);
        
        //�������ʲ����ά���ʤ�(�����)
        decimal = document.dateForm.elements[BP].value.indexOf(".",0); 
        len = document.dateForm.elements[BP].value.length;
        if(decimal == -1){
            document.dateForm.elements[BP].value = document.dateForm.elements[BP].value+'.00';
        }else if(len == decimal+2){
            document.dateForm.elements[BP].value = document.dateForm.elements[BP].value+'0';
        }
        
        //�����Ǥʤ����϶����֤�
        if(isNaN(document.dateForm.elements[BP].value) == true){
            document.dateForm.elements[BP].value = "";
        }
        document.dateForm.elements[BP].value = trimFixed(document.dateForm.elements[BP].value);
        document.dateForm.elements[TA].value = myFormatNumber(document.dateForm.elements[TA].value);
        document.dateForm.elements[BA].value = myFormatNumber(document.dateForm.elements[BA].value);
        document.dateForm.elements[BP].value = myFormatNumber(document.dateForm.elements[BP].value);
        
        return true;
    }else{
        return false;
    }
}

//��ȴ���������ǡ��ǹ��׻�(�ͤ����)
function Tax_Cal2(goods_id,sale_num,s_price_i,s_price_d,coax,sale_amount,c_price_i,c_price_d,cost_amount,tax_franct,tax_amount,total_price){

    var HG  = goods_id;
    var ON  = sale_num;
    var PI  = s_price_i;
    var PD  = s_price_d;
    var BA  = sale_amount;
    var PI2 = c_price_i;
    var PD2 = c_price_d;
    var BA2 = cost_amount;
    var TA  = tax_amount;
    var BP  = total_price;
    //������Ψ
    var tax_value = 0.05;

    //hidden�ξ���ID�����뤫
    if(document.dateForm.elements[HG].value != ""){
        //�׻���
        document.dateForm.elements[BA].value = document.dateForm.elements[ON].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
        //�ڼΤƤξ��
        if(coax == '1'){
            document.dateForm.elements[BA].value = Math.floor(document.dateForm.elements[BA].value * 100)/100;
        //�ͼθ����ξ��
        }else if(coax == '2'){
            document.dateForm.elements[BA].value = Math.round(document.dateForm.elements[BA].value * 100)/100;
        //�ھ夲�ξ��
        }else if(coax == '3'){
            document.dateForm.elements[BA].value = Math.ceil(document.dateForm.elements[BA].value * 100)/100;
        }
        
        //�������ʲ����ά���ʤ�(�����)
        decimal = document.dateForm.elements[BA].value.indexOf(".",0); 
        len = document.dateForm.elements[BA].value.length;
        if(decimal == -1){
            document.dateForm.elements[BA].value = document.dateForm.elements[BA].value+'.00';
        }else if(len == decimal+2){
            document.dateForm.elements[BA].value = document.dateForm.elements[BA].value+'0';
        }
        
        //�����Ǥʤ����϶����֤�
        if(isNaN(document.dateForm.elements[BA].value) == true){
            document.dateForm.elements[BA].value = "";
        }

        //�׻���
        document.dateForm.elements[BA2].value = document.dateForm.elements[ON].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
        //�ڼΤƤξ��
        if(coax == '1'){
            document.dateForm.elements[BA2].value = Math.floor(document.dateForm.elements[BA2].value * 100)/100;
        //�ͼθ����ξ��
        }else if(coax == '2'){
            document.dateForm.elements[BA2].value = Math.round(document.dateForm.elements[BA2].value * 100)/100;
        //�ھ夲�ξ��
        }else if(coax == '3'){
            document.dateForm.elements[BA2].value = Math.ceil(document.dateForm.elements[BA2].value * 100)/100;
        }
        
        //�������ʲ����ά���ʤ�(�����)
        decimal = document.dateForm.elements[BA2].value.indexOf(".",0); 
        len = document.dateForm.elements[BA2].value.length;
        if(decimal == -1){
            document.dateForm.elements[BA2].value = document.dateForm.elements[BA2].value+'.00';
        }else if(len == decimal+2){
            document.dateForm.elements[BA2].value = document.dateForm.elements[BA2].value+'0';
        }
        
        //�����Ǥʤ����϶����֤�
        if(isNaN(document.dateForm.elements[BA2].value) == true){
            document.dateForm.elements[BA2].value = "";
        }

        //�����ǡ��ǹ���
        document.dateForm.elements[TA].value = eval(document.dateForm.elements[ON].value * (eval(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value))) * tax_value;
        //�ڼΤƤξ��
        if(tax_franct == '1'){
            document.dateForm.elements[TA].value = Math.floor(document.dateForm.elements[TA].value * 100)/100;
        //�ͼθ����ξ��
        }else if(tax_franct == '2'){
            document.dateForm.elements[TA].value = Math.round(document.dateForm.elements[TA].value * 100)/100;
        //�ھ夲�ξ��
        }else if(tax_franct == '3'){
            document.dateForm.elements[TA].value = Math.ceil(document.dateForm.elements[TA].value * 100)/100;
        }
        
        //�������ʲ����ά���ʤ�(�����)
        decimal = document.dateForm.elements[TA].value.indexOf(".",0); 
        len = document.dateForm.elements[TA].value.length;
        if(decimal == -1){
            document.dateForm.elements[TA].value = document.dateForm.elements[TA].value+'.00';
        }else if(len == decimal+2){
            document.dateForm.elements[TA].value = document.dateForm.elements[TA].value+'0';
        }
        
        //�����Ǥʤ����϶����֤�
        if(isNaN(document.dateForm.elements[TA].value) == true){
            document.dateForm.elements[TA].value = "";
        }
        
        document.dateForm.elements[BP].value = eval(document.dateForm.elements[BA].value) + eval(document.dateForm.elements[TA].value);
        
        //�������ʲ����ά���ʤ�(�����)
        decimal = document.dateForm.elements[BP].value.indexOf(".",0); 
        len = document.dateForm.elements[BP].value.length;
        if(decimal == -1){
            document.dateForm.elements[BP].value = document.dateForm.elements[BP].value+'.00';
        }else if(len == decimal+2){
            document.dateForm.elements[BP].value = document.dateForm.elements[BP].value+'0';
        }
        
        //�����Ǥʤ����϶����֤�
        if(isNaN(document.dateForm.elements[BP].value) == true){
            document.dateForm.elements[BP].value = "";
        }
        document.dateForm.elements[BP].value = trimFixed(document.dateForm.elements[BP].value);
        document.dateForm.elements[TA].value = myFormatNumber(document.dateForm.elements[TA].value);
        document.dateForm.elements[BA].value = myFormatNumber(document.dateForm.elements[BA].value);
        document.dateForm.elements[BP].value = myFormatNumber(document.dateForm.elements[BP].value);
        
        return true;
    }else{
        return false;
    }
}

//�����������ξ軻
function Mult(id,num,price_i,price_d,amount,coax){

    var GI  = id;
    var SN  = num;
    var PI  = price_i;
    var PD  = price_d;
    var SA  = amount;

    //hidden�ξ���ID�����뤫
    if(document.dateForm.elements[GI].value != ""){
        var str  = document.dateForm.elements[PI].value;
        var str2 = document.dateForm.elements[PD].value;
        if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){
            //�׻���
            document.dateForm.elements[SA].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
        
            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
            }
            
            //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
            var str = document.dateForm.elements[SN].value;
            if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1){
                document.dateForm.elements[SA].value = "";
            }

            document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
            document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
        }else{
            document.dateForm.elements[SA].value = "";
        }
        return true;
    }else{
        return false;
    }
}

/**
 * ñ���߿��̡��켰���� ��׻�����
 *
 * ����ޥ�����ͽ��ǡ���������ͽ���񡢼����ɼ�������ɼ�������ˤ�����ǻ���
 *
 *  sale_num�����̤Υե�����̾
 *  c_price_i��ñ���������ˤΥե�����̾
 *  c_price_d��ñ���ʾ����ˤΥե�����̾
 *  cost_amount����פ�ɽ������ե�����̾
 *  setn���켰�����å��Υե�����̾
 *  coax���ޤ���ʬ
 *  place������Ƚ���ʬ
 *  price_div�����������Ƚ���ʬ�ʶ����ȸ���������ʳ�������
 */
function Mult2(sale_num,c_price_i,c_price_d,cost_amount,setn,coax,place,price_div){

    var SE  = setn;

    var SN  = sale_num;

    var PI2 = c_price_i;
    var PD2 = c_price_d;
    var SA2 = cost_amount;

    //�ܵ��褬���򤵤�Ƥ��뤫Ƚ��
    if(coax != ""){

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI2].value;
        var str2 = document.dateForm.elements[PD2].value;
        if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){

            //�ǥե���Ȥǡ���������00������
            if(document.dateForm.elements[PI2].value != "" && isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD2].value == "" && place != true){
                document.dateForm.elements[PD2].value = "00";
            }

            //���켰�������̡ߡ���ñ���ߣ���ݤ᤿��ۤ�ɽ��
            if((document.dateForm.elements[SE].checked == true || document.dateForm.elements[SE].value == '�켰') && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA2].value = 1 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));

            //���켰�ߡ����̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));

            //���켰�������̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if((document.dateForm.elements[SE].checked == true || document.dateForm.elements[SE].value == '�켰') && document.dateForm.elements[SN].value != ""){
                if(price_div == undefined){
                    //�������ξ���ñ���߿��̤�ݤ᤿��ۤ�ɽ��
                    document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                }else{
                    //�������ξ���ñ���߿��̤�ݤ᤿��ۤ�ɽ��
                    document.dateForm.elements[SA2].value = 1 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                }

            //���켰�ߡ����̡ߡ���0��ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA2].value = 0 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            }

            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
            }
            
            //���켰�������̡ߤ�Ƚ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                //���켰�������̡�

                var str = document.dateForm.elements[SN].value;
                //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
                if(isNaN(document.dateForm.elements[SA2].value) == true || str.search(/.*\..*/i) != -1){
                    document.dateForm.elements[SA2].value = "";
                }
            }else{
                //���켰�ߡ����̡�
                //���켰�������̡�

                //�����ǤϤʤ����
                if(isNaN(document.dateForm.elements[SA2].value) == true){
                    document.dateForm.elements[SA2].value = "";
                }
            }

            document.dateForm.elements[SA2].value = trimFixed(document.dateForm.elements[SA2].value);
            document.dateForm.elements[SA2].value = myFormatNumber(document.dateForm.elements[SA2].value);
        }else{
            document.dateForm.elements[SA2].value = "";
        }   
        return true;
    }else{
        return false;
    }
}

//�����������ξ軻(�׻������)
function Mult_double(goods_id,sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,coax){

    var GI  = goods_id;
    var SN  = sale_num;

    var PI  = s_price_i;
    var PD  = s_price_d;
    var SA  = sale_amount;

    var PI2 = c_price_i;
    var PD2 = c_price_d;
    var SA2 = cost_amount;

    //hidden�ξ���ID�����뤫
    if(document.dateForm.elements[GI].value != ""){

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI].value;
        var str2 = document.dateForm.elements[PD].value;
        if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){
            //�׻���
            document.dateForm.elements[SA].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
        
            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
            }
            
            //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
            var str = document.dateForm.elements[SN].value;
            if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1){
                document.dateForm.elements[SA].value = "";
            }
            document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
            document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
        }else{
            document.dateForm.elements[SA].value = "";
        }

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI2].value;
        var str2 = document.dateForm.elements[PD2].value;
        if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){
            //�׻���
            document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                
            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
            }
            
            //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
            var str = document.dateForm.elements[SN].value;
            if(isNaN(document.dateForm.elements[SA2].value) == true || str.search(/.*\..*/i) != -1){
                document.dateForm.elements[SA2].value = "";
            }

            document.dateForm.elements[SA2].value = trimFixed(document.dateForm.elements[SA2].value);
            document.dateForm.elements[SA2].value = myFormatNumber(document.dateForm.elements[SA2].value);
        }else{
            document.dateForm.elements[SA2].value = "";
        }   
        return true;
    }else{
        return false;
    }
}

//������Ͽ�ǻ��Ѥ��롣�����������ξ軻(�׻������)
//function Mult_double2(sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,setn,coax,place,daiko_coax){
function Mult_double2(sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,setn,coax,place,daiko_coax,contract_div,act_div){

    var SE  = setn;

    var SN  = sale_num;

    var PI  = s_price_i;
    var PD  = s_price_d;
    var SA  = sale_amount;

    var PI2 = c_price_i;
    var PD2 = c_price_d;
    var SA2 = cost_amount;


    //�ܵ��褬���򤵤�Ƥ��뤫Ƚ��
    if(coax != ""){

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI].value;
        var str2 = document.dateForm.elements[PD].value;

        if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){

            //�ǥե���Ȥǡ���������00������
            if(document.dateForm.elements[PI].value != "" && isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD].value == "" && place != true){
                document.dateForm.elements[PD].value = "00";
            }

            //���켰�������̡ߡ���ñ���ߣ���ݤ᤿��ۤ�ɽ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA].value = 1 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            //���켰�ߡ����̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            //���켰�������̡�����ñ���ߣ���ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA].value = 1 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            //���켰�ߡ����̡ߡ���0��ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA].value = 0 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            }

            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
            }
            
            //���켰�ߡ����̡���Ƚ��
            if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                //���켰�ߡ����̡�

                var str = document.dateForm.elements[SN].value;
                //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
                if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1){
                    document.dateForm.elements[SA].value = "";
                }
            }else{
                //���켰�������̡�
                //���켰�������̡�

                //�����ǤϤʤ����
                if(isNaN(document.dateForm.elements[SA].value) == true){
                    document.dateForm.elements[SA].value = "";
                }
            }

            document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
            document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
        }else{
            document.dateForm.elements[SA].value = "";
        }

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI2].value;
        var str2 = document.dateForm.elements[PD2].value;
        if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){

            //�ǥե���Ȥǡ���������00������
            if(document.dateForm.elements[PI2].value != "" && isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD2].value == "" && place != true){
                document.dateForm.elements[PD2].value = "00";
            }

            //���켰�������̡ߡ���ñ���ߣ���ݤ᤿��ۤ�ɽ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA2].value = 1 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            //���켰�ߡ����̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            //���켰�������̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value != ""){
                //�����ɼ���������ξ�硢�Ķȸ���������ۤ�Ʊ�ͤ�ñ���ߣ��ˤ���
                if((contract_div == "2" || contract_div == "3") && act_div == "3"){
                    document.dateForm.elements[SA2].value = 1 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                }else{
                    document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                }
            //���켰�ߡ����̡ߡ���0��ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA2].value = 0 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            }
                
            //����daiko_coax�����ꤵ�줿���
            if(daiko_coax != undefined && daiko_coax != ""){
                coax = daiko_coax;
            }

            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
            }
            
            //���켰�������̡ߤ�Ƚ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                //���켰�������̡�

                var str = document.dateForm.elements[SN].value;
                //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
                if(isNaN(document.dateForm.elements[SA2].value) == true || str.search(/.*\..*/i) != -1){
                    document.dateForm.elements[SA2].value = "";
                }
            }else{
                //���켰�ߡ����̡�
                //���켰�������̡�

                //�����ǤϤʤ����
                if(isNaN(document.dateForm.elements[SA2].value) == true){
                    document.dateForm.elements[SA2].value = "";
                }
            }

            document.dateForm.elements[SA2].value = trimFixed(document.dateForm.elements[SA2].value);
            document.dateForm.elements[SA2].value = myFormatNumber(document.dateForm.elements[SA2].value);
        }else{
            document.dateForm.elements[SA2].value = "";
        }   
        return true;
    }else{
        return false;
    }
}


//��Ԥξ��η�����Ͽ�ǻ��Ѥ��롣�����������ξ軻(�׻������)
function Mult_double3(sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,setn,coax,place,row,detail,daiko_coax){

    var SE  = setn;

    var SN  = sale_num;

    var PI  = s_price_i;
    var PD  = s_price_d;
    var SA  = sale_amount;

    var PI2 = c_price_i;
    var PD2 = c_price_d;
    var SA2 = cost_amount;

    //�ܵ��褬���򤵤�Ƥ��뤫Ƚ��
    if(coax != ""){

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI].value;
        var str2 = document.dateForm.elements[PD].value;

        if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){

            //�ǥե���Ȥǡ���������00������
            if(document.dateForm.elements[PI].value != "" && isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD].value == "" && place != true){
                document.dateForm.elements[PD].value = "00";
            }
    
            //���켰�������̡ߡ���ñ���ߣ���ݤ᤿��ۤ�ɽ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA].value = 1 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            //���켰�ߡ����̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            //���켰�������̡�����ñ���ߣ���ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA].value = 1 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            //���켰�ߡ����̡ߡ���0��ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA].value = 0 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            }

            //��Է׻��ѿ�
            var sum_sale = document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value;

            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
            }
            
            //���켰�ߡ����̡���Ƚ��
            if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                //���켰�ߡ����̡�

                var str = document.dateForm.elements[SN].value;
                //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
                if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1){
                    document.dateForm.elements[SA].value = "";
                }
            }else{
                //���켰�������̡�
                //���켰�������̡�

                //�����ǤϤʤ����
                if(isNaN(document.dateForm.elements[SA].value) == true){
                    document.dateForm.elements[SA].value = "";
                }
            }
            document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
            document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
        }else{
            document.dateForm.elements[SA].value = "";
        }

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI2].value;
        var str2 = document.dateForm.elements[PD2].value;
        if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){

            //�ǥե���Ȥǡ���������00������
            if(document.dateForm.elements[PI2].value != "" && isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD2].value == "" && place != true){
                document.dateForm.elements[PD2].value = "00";
            }

            //��������Ƚ��
            if(detail == true){
                //��������

                //��Ԥξ�硢�Ķȸ�������԰������ܸ�����
                if(document.dateForm.elements["daiko_check"].value != 1 && sum_sale != "" && isNaN(sum_sale) == false){
                    
                    //��԰����������������԰�����Ψ��
                    if(document.dateForm.elements["act_request_rate"].value > 0){
                        //���ꤢ��
                    
                        //���ñ������԰�����
                        var daiko_money = sum_sale * (document.dateForm.elements["act_request_rate"].value / 100);
                        daiko_money = trimFixed(daiko_money);

                        var d_money = String(daiko_money);
                        //��������ʬ��
                        mydata = d_money.split(".");

                        //�����ˤʤ��ǽ��������١���������ݤ��
                        var syosu = trimFixed(daiko_money * 100) - trimFixed(eval(mydata[0] * 100));
                        syosu = trimFixed(syosu);

                        syosu = String(syosu);

                        //����Ƚ��
                        var check = syosu.indexOf(".",0);
                        if(check != -1){
                            //��������ʬ��
                            smydata = syosu.split(".");
                            document.dateForm.elements[PD2].value = eval(smydata[0]);
                        }else{
                            //��������ɽ��
                            document.dateForm.elements[PD2].value = syosu;
                        }
                        //�����������ʤ飰���
                        if(document.dateForm.elements[PD2].value.length == 1){
                            document.dateForm.elements[PD2].value = "0" + document.dateForm.elements[PD2].value;
                        }

                        //������
                        document.dateForm.elements[PI2].value = eval(mydata[0]);
                    }else{
                        //����ʤ��ξ��ϡ�������
                        document.dateForm.elements[PI2].value = "0";
                        document.dateForm.elements[PD2].value = "00";
                    }
                }
            }else{
                //��Ͽ����

                //��Ԥξ�硢�Ķȸ�������԰������ܸ�����
                if(document.dateForm.elements["daiko_check"][0].checked == false && sum_sale != "" && isNaN(sum_sale) == false){
                    //��԰����������������԰�����Ψ��
                    if(document.dateForm.elements["act_request_rate"].value > 0){
                        //���ꤢ��
                
                        //���ñ������԰�����
                        var daiko_money = sum_sale * (document.dateForm.elements["act_request_rate"].value / 100);
                        daiko_money = trimFixed(daiko_money);

                        var d_money = String(daiko_money);
                        //��������ʬ��
                        mydata = d_money.split(".");

                        //�����ˤʤ��ǽ��������١���������ݤ��
                        var syosu = trimFixed(daiko_money * 100) - trimFixed(eval(mydata[0] * 100));
                        syosu = trimFixed(syosu);

                        syosu = String(syosu);

                        //����Ƚ��
                        var check = syosu.indexOf(".",0);
                        if(check != -1){
                            //��������ʬ��
                            smydata = syosu.split(".");
                            document.dateForm.elements[PD2].value = eval(smydata[0]);
                        }else{
                            //��������ɽ��
                            document.dateForm.elements[PD2].value = syosu;
                        }
                        //�����������ʤ飰���
                        if(document.dateForm.elements[PD2].value.length == 1){
                            document.dateForm.elements[PD2].value = "0" + document.dateForm.elements[PD2].value;
                        }

                        //������
                        document.dateForm.elements[PI2].value = eval(mydata[0]);

                    }else{
                        //����ʤ��ξ��ϡ�������
                        document.dateForm.elements[PI2].value = "0";
                        document.dateForm.elements[PD2].value = "00";
                    }
                }
            }

            //���켰�������̡ߡ���ñ���ߣ���ݤ᤿��ۤ�ɽ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA2].value = 1 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            //���켰�ߡ����̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            //���켰�������̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            //���켰�������̡�����ñ���ߣ���ݤ᤿��ۤ�ɽ������Ԥ��������ξ��ϸ�������̴ط��ʤ���
            }else if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value != ""){
                //document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                document.dateForm.elements[SA2].value = 1 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            //���켰�ߡ����̡ߡ���0��ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA2].value = 0 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            }

            //��������Ƚ��
            if(detail == true){
                //����

                //�����ɼȽ��
                if(document.dateForm.elements["daiko_check"].value != 1){
                    //������δݤ�����

                    //�ڼΤƤξ��
                    if(daiko_coax == '1'){
                        document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
                    //�ͼθ����ξ��
                    }else if(daiko_coax == '2'){
                        document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
                    //�ھ夲�ξ��
                    }else if(daiko_coax == '3'){
                        document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
                    //�����褬���򤵤�Ƥ��ʤ��ä����ھ夲
                    }else{
                        document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
                    }
                }else{
                    //������δݤ�����

                    //�ڼΤƤξ��
                    if(coax == '1'){
                        document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
                    //�ͼθ����ξ��
                    }else if(coax == '2'){
                        document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
                    //�ھ夲�ξ��
                    }else if(coax == '3'){
                        document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
                    }
                }
            }else{
                //��Ͽ

                //�����ɼȽ��
                if(document.dateForm.elements["daiko_check"][0].checked == false){
                    //������δݤ�����

                    //�ڼΤƤξ��
                    if(daiko_coax == '1'){
                        document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
                    //�ͼθ����ξ��
                    }else if(daiko_coax == '2'){
                        document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
                    //�ھ夲�ξ��
                    }else if(daiko_coax == '3'){
                        document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
                    //�����褬���򤵤�Ƥ��ʤ��ä����ھ夲
                    }else{
                        document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
                    }
                }else{
                    //������δݤ�����

                    //�ڼΤƤξ��
                    if(coax == '1'){
                        document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
                    //�ͼθ����ξ��
                    }else if(coax == '2'){
                        document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
                    //�ھ夲�ξ��
                    }else if(coax == '3'){
                        document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
                    }
                }
            }
            
            //���켰�������̡ߤ�Ƚ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                //���켰�������̡�

                var str = document.dateForm.elements[SN].value;
                //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
                if(isNaN(document.dateForm.elements[SA2].value) == true || str.search(/.*\..*/i) != -1){
                    document.dateForm.elements[SA2].value = "";
                }
            }else{
                //���켰�ߡ����̡�
                //���켰�������̡�

                //�����ǤϤʤ����
                if(isNaN(document.dateForm.elements[SA2].value) == true){
                    document.dateForm.elements[SA2].value = "";
                }
            }

            document.dateForm.elements[SA2].value = trimFixed(document.dateForm.elements[SA2].value);
            document.dateForm.elements[SA2].value = myFormatNumber(document.dateForm.elements[SA2].value);
        }else{
            document.dateForm.elements[SA2].value = "";
        }   
        return true;

    }else{

        return false;
    }
}

//��Ԥξ��η�����Ͽ�ǻ��Ѥ��롣Mult_double3�Ȱ㤦�Τϡ�������ʬ�κƷ׻���Ԥ�
function Mult_double4(sale_num,s_price_i,sale_amount,c_price_i,cost_amount,setn,coax,daiko_coax){

    //�ܵ��褬���򤵤�Ƥ��뤫Ƚ��
    if(coax != ""){

        for(var i=1;i<=5;i++){

            var SE  = setn+"["+i+"]";
            var SN  = sale_num+"["+i+"]";
            var PI  = s_price_i+"["+i+"][1]";
            var PD  = s_price_i+"["+i+"][2]";
            var SA  = sale_amount+"["+i+"]";
            var PI2 = c_price_i+"["+i+"][1]";
            var PD2 = c_price_i+"["+i+"][2]";
            var SA2 = cost_amount+"["+i+"]";

            //���̡��켰�����ꤵ��Ƥ���ԤΤ߷׻������¹�
            if(document.dateForm.elements[SN].value != "" || document.dateForm.elements[SE].checked == true){

                //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
                var str  = document.dateForm.elements[PI].value;
                var str2 = document.dateForm.elements[PD].value;

                if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){

                    //�ǥե���Ȥǡ���������00������
                    if(document.dateForm.elements[PI].value != "" && isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD].value == ""){
                        document.dateForm.elements[PD].value = "00";
                    }
        
                    //���켰�������̡ߡ���ñ���ߣ���ݤ᤿��ۤ�ɽ��
                    if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                        document.dateForm.elements[SA].value = 1 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
                    //���켰�ߡ����̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
                    }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                        document.dateForm.elements[SA].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
                    //���켰�������̡�����ñ���ߣ���ݤ᤿��ۤ�ɽ��
                    }else if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value != ""){
                        document.dateForm.elements[SA].value = 1 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
                    //���켰�ߡ����̡ߡ���0��ɽ��
                    }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value == ""){
                        document.dateForm.elements[SA].value = 0 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
                    }

                    //��Է׻��ѿ�
                    var sum_sale = document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value;

                    //�ڼΤƤξ��
                    if(coax == '1'){
                        document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);

                    //�ͼθ����ξ��
                    }else if(coax == '2'){
                        document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
                    //�ھ夲�ξ��
                    }else if(coax == '3'){
                        document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
                    }
                    
                    //���켰�ߡ����̡���Ƚ��
                    if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                        //���켰�ߡ����̡�

                        var str = document.dateForm.elements[SN].value;
                        //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
                        if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1){
                            document.dateForm.elements[SA].value = "";
                        }
                    }else{
                        //���켰�������̡�
                        //���켰�������̡�

                        //�����ǤϤʤ����
                        if(isNaN(document.dateForm.elements[SA].value) == true){
                            document.dateForm.elements[SA].value = "";
                        }
                    }

                    document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
                    document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
                }else{
                    document.dateForm.elements[SA].value = "";
                }

                //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
                var str  = document.dateForm.elements[PI2].value;
                var str2 = document.dateForm.elements[PD2].value;
                if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){

                    //�ǥե���Ȥǡ���������00������
                    if(document.dateForm.elements[PI2].value != "" && isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD2].value == ""){
                        document.dateForm.elements[PD2].value = "00";
                    }

                    //��Ԥξ�硢�Ķȸ�������԰������ܸ�����
                    if(document.dateForm.elements["daiko_check"][0].checked == false && sum_sale != "" && isNaN(sum_sale) == false){
                        //��԰����������������԰�����Ψ��
                        if(document.dateForm.elements["act_request_rate"].value > 0){
                            //���ꤢ��
//alert(daiko_coax);                        
//alert(coax);                        
                        
                            //���ñ������԰�����
                            var daiko_money = sum_sale * (document.dateForm.elements["act_request_rate"].value / 100);
                            daiko_money = trimFixed(daiko_money);

                            var d_money = String(daiko_money);
                            //��������ʬ��
                            mydata = d_money.split(".");

                            //�����ˤʤ��ǽ��������١���������ݤ��
                            var syosu = trimFixed(daiko_money * 100) - trimFixed(eval(mydata[0] * 100));
                            syosu = trimFixed(syosu);

                            syosu = String(syosu);

                            //����Ƚ��
                            var check = syosu.indexOf(".",0);
                            if(check != -1){
                                //��������ʬ��
                                smydata = syosu.split(".");
                                document.dateForm.elements[PD2].value = eval(smydata[0]);
                            }else{
                                //��������ɽ��
                                document.dateForm.elements[PD2].value = syosu;
                            }
                            //�����������ʤ飰���
                            if(document.dateForm.elements[PD2].value.length == 1){
                                document.dateForm.elements[PD2].value = "0" + document.dateForm.elements[PD2].value;
                            }

                            //������
                            document.dateForm.elements[PI2].value = eval(mydata[0]);
                        }else{
                            //����ʤ��ξ��ϡ�������
                            document.dateForm.elements[PI2].value = "0";
                            document.dateForm.elements[PD2].value = "00";
                        }
                    }

                    //���켰�������̡ߡ���ñ���ߣ���ݤ᤿��ۤ�ɽ��
                    if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                        document.dateForm.elements[SA2].value = 1 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                    //���켰�ߡ����̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
                    }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                        document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                    //���켰�������̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
                    }else if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value != ""){
                        document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                    //���켰�ߡ����̡ߡ���0��ɽ��
                    }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value == ""){
                        document.dateForm.elements[SA2].value = 0 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                    }

                    //�ڼΤƤξ��
                    if(daiko_coax == '1'){
                        document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
                    //�ͼθ����ξ��
                    }else if(daiko_coax == '2'){
                        document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
                    //�ھ夲�ξ��
                    }else if(daiko_coax == '3'){
                        document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
                    //�����褬���򤵤�Ƥ��ʤ��ä����ھ夲
                    }else{
                        document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
                    }
                    
                    //���켰�������̡ߤ�Ƚ��
                    if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                        //���켰�������̡�

                        var str = document.dateForm.elements[SN].value;
                        //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
                        if(isNaN(document.dateForm.elements[SA2].value) == true || str.search(/.*\..*/i) != -1){
                            document.dateForm.elements[SA2].value = "";
                        }
                    }else{
                        //���켰�ߡ����̡�
                        //���켰�������̡�

                        //�����ǤϤʤ����
                        if(isNaN(document.dateForm.elements[SA2].value) == true){
                            document.dateForm.elements[SA2].value = "";
                        }
                    }

                    document.dateForm.elements[SA2].value = trimFixed(document.dateForm.elements[SA2].value);
                    document.dateForm.elements[SA2].value = myFormatNumber(document.dateForm.elements[SA2].value);
                }else{
                    document.dateForm.elements[SA2].value = "";
                }   
            }
        }
        return true;
    }else{

        return false;
    }
}

//��Ԥξ���ͽ��ǡ��������ǻ��Ѥ��롣�����������ξ軻(�׻������)
function Mult_double_Plan(sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,setn,coax,place,row,rate,daiko,detail){

    var SE  = setn;

    var SN  = sale_num;

    var PI  = s_price_i;
    var PD  = s_price_d;
    var SA  = sale_amount;

    var PI2 = c_price_i;
    var PD2 = c_price_d;
    var SA2 = cost_amount;

    //�ܵ��褬���򤵤�Ƥ��뤫Ƚ��
    if(coax != ""){

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI].value;
        var str2 = document.dateForm.elements[PD].value;

        if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){

            //�ǥե���Ȥǡ���������00������
            if(document.dateForm.elements[PI].value != "" && isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD].value == "" && place != true){
                document.dateForm.elements[PD].value = "00";
            }
    
            //���켰�������̡ߡ���ñ���ߣ���ݤ᤿��ۤ�ɽ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA].value = 1 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            //���켰�ߡ����̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            //���켰�������̡�����ñ���ߣ���ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA].value = 1 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            //���켰�ߡ����̡ߡ���0��ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA].value = 0 * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
            }

            //��Է׻��ѿ�
            var sum_sale = (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));

            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
            }
            
            //���켰�ߡ����̡���Ƚ��
            if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                //���켰�ߡ����̡�

                var str = document.dateForm.elements[SN].value;
                //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
                if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1){
                    document.dateForm.elements[SA].value = "";
                }
            }else{
                //���켰�������̡�
                //���켰�������̡�

                //�����ǤϤʤ����
                if(isNaN(document.dateForm.elements[SA].value) == true){
                    document.dateForm.elements[SA].value = "";
                }
            }
            document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
            document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
        }else{
            document.dateForm.elements[SA].value = "";
        }

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI2].value;
        var str2 = document.dateForm.elements[PD2].value;
        if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){

            //�ǥե���Ȥǡ���������00������
            if(document.dateForm.elements[PI2].value != "" && isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD2].value == "" && place != true){
                document.dateForm.elements[PD2].value = "00";
            }

            //��������Ƚ��
            if(detail == true){
                //��������

                //��Ԥξ�硢�Ķȸ�������԰������ܸ�����
                if(daiko != 1 && sum_sale != "" && isNaN(sum_sale) == false){
                    //��԰����������������԰�����Ψ��
                    if(rate > 0){
                        //���ꤢ��
                        var daiko_money = sum_sale * (rate / 100);

                        //�ڼΤƤξ��
                        if(coax == '1'){
                            daiko_money = Math.floor(daiko_money);
                        //�ͼθ����ξ��
                        }else if(coax == '2'){
                            daiko_money = Math.round(daiko_money);
                        //�ھ夲�ξ��
                        }else if(coax == '3'){
                            daiko_money = Math.ceil(daiko_money);
                        }
                    }else{
                        //����ʤ��ξ��ϡ�������
                        var daiko_money = "0";
                    }
                    document.dateForm.elements[PI2].value = eval(daiko_money);
                }
            }else{
                //��Ͽ����

                //��Ԥξ�硢�Ķȸ�������԰������ܸ�����
                if(daiko != 1 && sum_sale != "" && isNaN(sum_sale) == false){
                    //��԰����������������԰�����Ψ��
                    if(rate > 0){
                        //���ꤢ��
                        var daiko_money = sum_sale * (rate / 100);

                        //�ڼΤƤξ��
                        if(coax == '1'){
                            daiko_money = Math.floor(daiko_money);
                        //�ͼθ����ξ��
                        }else if(coax == '2'){
                            daiko_money = Math.round(daiko_money);
                        //�ھ夲�ξ��
                        }else if(coax == '3'){
                            daiko_money = Math.ceil(daiko_money);
                        }
                    }else{
                        //����ʤ��ξ��ϡ�������
                        var daiko_money = "0";
                    }
                    document.dateForm.elements[PI2].value = eval(daiko_money);
                }
            }

            //���켰�������̡ߡ���ñ���ߣ���ݤ᤿��ۤ�ɽ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA2].value = 1 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            //���켰�ߡ����̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            //���켰�������̡�����ñ���߿��̤�ݤ᤿��ۤ�ɽ��
            }else if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value != ""){
                document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            //���켰�ߡ����̡ߡ���0��ɽ��
            }else if(document.dateForm.elements[SE].checked == false && document.dateForm.elements[SN].value == ""){
                document.dateForm.elements[SA2].value = 0 * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
            }
                
            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
            }
            
            //���켰�������̡ߤ�Ƚ��
            if(document.dateForm.elements[SE].checked == true && document.dateForm.elements[SN].value == ""){
                //���켰�������̡�

                var str = document.dateForm.elements[SN].value;
                //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
                if(isNaN(document.dateForm.elements[SA2].value) == true || str.search(/.*\..*/i) != -1){
                    document.dateForm.elements[SA2].value = "";
                }
            }else{
                //���켰�ߡ����̡�
                //���켰�������̡�

                //�����ǤϤʤ����
                if(isNaN(document.dateForm.elements[SA2].value) == true){
                    document.dateForm.elements[SA2].value = "";
                }
            }

            document.dateForm.elements[SA2].value = trimFixed(document.dateForm.elements[SA2].value);
            document.dateForm.elements[SA2].value = myFormatNumber(document.dateForm.elements[SA2].value);
        }else{
            document.dateForm.elements[SA2].value = "";
        }   
        return true;

    }else{

        return false;
    }
}

//�����������ξ軻(�׻������)�������ʤ����򤵤�Ƥ��ʤ��Ƥ�׻��¹�
function Mult_double_ren(sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,coax,place,cost_coax){

    var SN  = sale_num;

    var PI  = s_price_i;
    var PD  = s_price_d;
    var SA  = sale_amount;

    var PI2 = c_price_i;
    var PD2 = c_price_d;
    var SA2 = cost_amount;

    //����cost_coax�����ꤵ�줿���
    if(cost_coax == undefined){
    	cost_coax = coax;
    }

    //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
    var str  = document.dateForm.elements[PI].value;
    var str2 = document.dateForm.elements[PD].value;
    if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){

        //�ǥե���Ȥǡ���������00������
        if(document.dateForm.elements[PI].value != "" && isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD].value == "" && place != true){
            document.dateForm.elements[PD].value = "00";
        }

        //�׻���
        document.dateForm.elements[SA].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));

        //�ڼΤƤξ��
        if(coax == '1'){
            document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);
        //�ͼθ����ξ��
        }else if(coax == '2'){
            document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
        //�ھ夲�ξ��
        }else if(coax == '3'){
            document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
        }
        
        //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
        var str = document.dateForm.elements[SN].value;
        if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1 || document.dateForm.elements[SN].value == ""){
            document.dateForm.elements[SA].value = "";
        }
        document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
        document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
    }else{
        document.dateForm.elements[SA].value = "";
    }

    //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
    var str  = document.dateForm.elements[PI2].value;
    var str2 = document.dateForm.elements[PD2].value;
    if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){

        //�ǥե���Ȥǡ���������00������
        if(document.dateForm.elements[PI2].value != "" && isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && document.dateForm.elements[PD2].value == "" && place != true){
            document.dateForm.elements[PD2].value = "00";
        }

        //�׻���
        document.dateForm.elements[SA2].value = document.dateForm.elements[SN].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
                
        //�ڼΤƤξ��
        if(cost_coax == '1'){
            document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
        //�ͼθ����ξ��
        }else if(cost_coax == '2'){
            document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
        //�ھ夲�ξ��
        }else if(cost_coax == '3'){
            document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
        }
        
        //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
        var str = document.dateForm.elements[SN].value;
        if(isNaN(document.dateForm.elements[SA2].value) == true || str.search(/.*\..*/i) != -1 || document.dateForm.elements[SN].value == ""){
            document.dateForm.elements[SA2].value = "";
        }

        document.dateForm.elements[SA2].value = trimFixed(document.dateForm.elements[SA2].value);
        document.dateForm.elements[SA2].value = myFormatNumber(document.dateForm.elements[SA2].value);
    }else{
        document.dateForm.elements[SA2].value = "";
    }   
    return false;
}

//������Ʊ�Τξ軻
//(��ˤʤ��͡����̡�ñ��(����)��ñ��(����)��ñ��2(����)�����1��ñ��2(����)�����2���ݤ��ʬ)
//�����̡�ñ������ۤϡ��ե�����̾
function Bc_mul(id,num,price_i,price_d,amount,price_i2,price_d2,amount2,coax){
    var ID   = id;
    var NUM  = num;

    var PI   = price_i;
    var PD   = price_d;
    var AM   = amount;

    var PI2  = price_i2;
    var PD2  = price_d2;
    var AM2  = amount2;

    //�׻���
    document.dateForm.elements[AM].value = document.dateForm.elements[NUM].value * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));
    //�ڼΤƤξ��
    if(coax == '1'){
        document.dateForm.elements[AM].value = Math.floor(document.dateForm.elements[AM].value * 100)/100;
    //�ͼθ����ξ��
    }else if(coax == '2'){
        document.dateForm.elements[AM].value = Math.round(document.dateForm.elements[AM].value * 100)/100;
    //�ھ夲�ξ��
    }else if(coax == '3'){
        document.dateForm.elements[AM].value = Math.ceil(document.dateForm.elements[AM].value * 100)/100;
    }
    
    //�������ʲ����ά���ʤ�(�����)
    decimal = document.dateForm.elements[AM].value.indexOf(".",0); 
    len = document.dateForm.elements[AM].value.length;
    if(decimal == -1){
        document.dateForm.elements[AM].value = document.dateForm.elements[AM].value+'.00';
    }else if(len == decimal+2){
        document.dateForm.elements[AM].value = document.dateForm.elements[AM].value+'0';
    }
    
    //�����Ǥʤ����϶����֤�
    if(isNaN(document.dateForm.elements[AM].value) == true){
        document.dateForm.elements[AM].value = "";
    }
    
    document.dateForm.elements[AM].value = myFormatNumber(document.dateForm.elements[AM].value);

    //�׻���
    document.dateForm.elements[AM2].value = document.dateForm.elements[NUM].value * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));
    //�ڼΤƤξ��
    if(coax == '1'){
        document.dateForm.elements[AM2].value = Math.floor(document.dateForm.elements[AM2].value * 100)/100;
    //�ͼθ����ξ��
    }else if(coax == '2'){
        document.dateForm.elements[AM2].value = Math.round(document.dateForm.elements[AM2].value * 100)/100;
    //�ھ夲�ξ��
    }else if(coax == '3'){
        document.dateForm.elements[AM2].value = Math.ceil(document.dateForm.elements[AM2].value * 100)/100;
    }
    
    //�������ʲ����ά���ʤ�(�����)
    decimal = document.dateForm.elements[AM2].value.indexOf(".",0); 
    len = document.dateForm.elements[AM2].value.length;
    if(decimal == -1){
        document.dateForm.elements[AM2].value = document.dateForm.elements[AM2].value+'.00';
    }else if(len == decimal+2){
        document.dateForm.elements[AM2].value = document.dateForm.elements[AM2].value+'0';
    }
    
    //�����Ǥʤ����϶����֤�
    if(isNaN(document.dateForm.elements[AM2].value) == true){
        document.dateForm.elements[AM2].value = "";
    }

    document.dateForm.elements[AM2].value = myFormatNumber(document.dateForm.elements[AM2].value);

    return true;
}

/***********************�ڡ�������**************************/
//���Ϸ���(���̡�Ģɼ)��������ˡ��ʬ����
function Which_Type(output_type,next1,next2){
    var type = output_type;
    //Ģɼ�˥����å���������
    if(document.dateForm.elements[type][1].checked == true){
        //�̥�����ɥ������ܤ���
        document.dateForm.target="_blank";
        document.dateForm.action=next1;
    //���̤˥����å���������
    }else{ 
        //Ʊ������ɥ������ܤ���
        document.dateForm.target="_self";
        document.dateForm.action=next2;
    } 
}

//Ģɼ��POST����ݤ˻���
function PDF_POST(pdf){
    var pdf = pdf;
    document.dateForm.target="_blank";
    document.dateForm.action=pdf;
}

//�ڡ�������
function page_check(flg){
    //���Υץ������ξ��ϡ���Υץ�����������
    if(flg == 2){
        document.dateForm.f_page1.value = document.dateForm.f_page2.value;
    }
    document.dateForm.target="_self";
    document.dateForm.action="#";
    document.dateForm.submit();
}

//����󥯲���
function page_back(back){
    document.dateForm.f_page1.value = back - 1;
    document.dateForm.target="_self";
    document.dateForm.action="#";
    document.dateForm.submit();
}

//�ʤ��󥯲���
function page_next(next){
    document.dateForm.f_page1.value = next + 1;
    document.dateForm.target="_self";
    document.dateForm.action="#";
    document.dateForm.submit();
}


// �������������
// �ڡ�������
function page_check2(flg, me){
    document.dateForm.switch_page_flg.value = "t";
    // ���Υץ������ξ��ϡ���Υץ�����������
    if(flg == 2){
        document.dateForm.f_page1.value = document.dateForm.f_page2.value;
    }
    document.dateForm.target="_self";
    document.dateForm.action=me;
    document.dateForm.submit();
}

// ����󥯲���
function page_back2(back, me){
    document.dateForm.switch_page_flg.value = "t";
    document.dateForm.f_page1.value = back - 1;
    document.dateForm.target="_self";
    document.dateForm.action=me;
    document.dateForm.submit();
}

// �ʤ��󥯲���
function page_next2(next, me){
    document.dateForm.switch_page_flg.value = "t";
    document.dateForm.f_page1.value = next + 1;
    document.dateForm.target="_self";
    document.dateForm.action=me;
    document.dateForm.submit();
}




function Open_Win(page){
    document.dateForm.target="_blank";
    document.dateForm.action=page;
}

/********************�������å�����ȿž**********************/

//�����å��ܥå�����Value���ѹ�
//������Value�ͤ��ѹ�����ե�����̾��Value�͡�
function Check_value(c_name,str){
    document.dateForm.elements[c_name].value = str;
}

//�������å�
function Allcheck(num){
    var Y = "check"+num+"[check]";
    var A = "allcheck"+num+"[allcheck"+num+"]";
    for(var e=0;e<document.dateForm.elements.length;e++){
        //���ϥե���������Ƥǡ������å��ܥå�����
        if(document.dateForm.elements[e].name == A){
            //�����å�Ƚ��
            if(document.dateForm.elements[e].checked == true){
                for(var e=0;e<document.dateForm.elements.length;e++){
                    if(document.dateForm.elements[e].name == Y){
                        //�����å����դ���
                        document.dateForm.elements[e].checked = true;
                    }
                }
            }else{
                for(var e=0;e<document.dateForm.elements.length;e++){
                    if(document.dateForm.elements[e].name == Y){
                        //�����å��򳰤�
                        document.dateForm.elements[e].checked = false;
                    }
                }
            }
        }
    }
}

//�������å�
//����(ALL�����å��Υե�����̾�������å��оݤΥե�����̾�������å������)
function All_check(all_name,c_name,num){
    var A = all_name;
    //�����å�Ƚ��
    if(document.dateForm.elements[A].checked == true){
        for(var x=0;x<num;x++){
            var C = c_name+"["+x+"]";
            //�����å����դ���
            document.dateForm.elements[C].checked = true;
        }
    }else{
        for(var x=0;x<num;x++){
            var C = c_name+"["+x+"]";
            //�����å��򳰤�
            document.dateForm.elements[C].checked = false;
        }
    }
}

//��ȿž
function Allchange(){
    for(var c=12;c<22;c++){
        var I = "f_r_output"+c+"[in]";
        //�����å�Ƚ��
        for(var e=0;e<document.dateForm.elements.length;e++){
            //���ϥե���������Ƥǡ��饸���ܥ���
            if(document.dateForm.elements[e].name == I){
                //���ˡ��и�Ƚ��
                if(document.dateForm.elements[e].value == "1"){
                    document.dateForm.elements[e].value = "2";
                }else{
                    document.dateForm.elements[e].value = "1";
                }
            }
        }
    }
    document.dateForm.submit();
}

//��ȿž

function Allchange_1(max, io_num){

    for(var c=0;c<io_num;c++){
    var I = "form_io_type["+c+"]";
    if(document.dateForm.elements[I][0].checked == true){
        document.dateForm.elements[I][1].checked = true;
    }else {
        document.dateForm.elements[I][0].checked = true;
    }
        sum(c, max);
    }
}

/********************Code_Value**********************/

//���ɽ��
function display(code,place,num){
    //��󥯹��ܤ�����̤�ʣ�����뤫
    if(num != undefined){
        display_flg = true;
    }else{
        display_flg = false;
    }
    //���𥳡���
    if(place=="position"){
        if(display_flg == true){
            var name = "f_position"+num+"[name]";
        }else{
            var name = "f_position[name]";
        }
        
        data = new Array(5);
        data['01']="�Ķ���"
        data['02']="��̳��"
        data['03']="��̳��"
        data['04']="������"
        data['05']="FC�����ƥ���"
    //�Ҹ˥�����
    }else if(place=="warehouse"){
        if(display_flg == true){
            var name = "f_warehouse"+num+"[name]";
        }else{
            var name = "f_warehouse[name]";
        }
        
        data = new Array(5);
        data['001']="A�Ҹ�"
        data['002']="B�Ҹ�"
        data['003']="C�Ҹ�"
        data['004']="D�Ҹ�"
        data['005']="E�Ҹ�"
    //�Ҹ˥�����
    }else if(place=="warehouse1"){
        var name = "form_ware[form_ware_name]";
        
        data = new Array(5);
        data['001']="A�Ҹ�"
        data['002']="B�Ҹ�"
        data['003']="C�Ҹ�"
        data['004']="D�Ҹ�"
        data['005']="E�Ҹ�"
    //�ȼ拾����
    }else if(place=="business"){
        if(display_flg == true){
            var name = "f_business"+num+"[name]";
        }else{
            var name = "f_business[name]";
        }
        
        data = new Array(5);
        data['00001']="�����ե������ȥա���"
        data['00002']="�ع��ط�"
        data['00003']="���Ŵط�"
        data['00004']="�ե��ߥ쥹"
        data['00005']="����ӥ�"
    //��ԥ�����
    }else if(place=="bank"){
        if(display_flg == true){
            var name = "f_bank"+num+"[name]";
        }else{
            var name = "f_bank[name]";
        }
        
        data = new Array(5);
        data['0001']="�������ԡ���ë��Ź"
        data['0002']="�ߤ��۶��"
        data['0003']="���潻ͧ���"
        data['0004']="UFJ���"
        data['0005']="�������ԡ����ͻ�Ź"
    //���ʶ�ʬ������
    }else if(place=="product"){
        if(display_flg == true){
            var name = "f_product"+num+"[name]";
        }else{
            var name = "f_product[name]";
        }
        
        data = new Array(5);
        data['0001']="��ԡ��Ⱦ���"
        data['0002']="Ǣ���ɻߺ޻�"
        data['0003']="Ǣ���ɻߺ޹���"
        data['0004']="���ھ���"
        data['0005']="������Ϣ"
    //�Ͷ�ʬ������
    }else if(place=="district"){
        if(display_flg == true){
            var name = "f_district"+num+"[name]";
        }else{
            var name = "f_district[name]";
        }
        
        data = new Array(5);
        data['0001']="Ǣ�Ɏ��ю܎����ގ�"
        data['0002']="Ǣ�Ɏˎߎˎߎ��ގ؎�"
        data['0003']="Ǣ�Ɏˎߎˎߎ��ڎ���"
        data['0004']="Ǣ�Ɏ��ݎ�����"
        data['0005']="Ǣ�Ɏˎߎˎߎ�������"
    //�����襳����
    }else if(place=="layer"){
        if(display_flg == true){
            var name = "f_layer"+num+"[name]";
        }else{
            var name = "f_layer[name]";
        }
        data = new Array(5);
        data['000001']="�������鹩��"
        data['000002']="��ե�"
        data['000003']="���եѥ���"
        data['000004']="��顼"
        data['000005']="�ꥨ��"
    //���ʥ�����
    }else if(place=="goods"){
        if(display_flg == true){
            var name = "f_goods"+num+"[name]";
        }else{
            var name = "f_goods[name]";
        }
        data = new Array(5);
        data['00000001']="����1"
        data['00000002']="����2"
        data['00000003']="����3"
        data['00000004']="����4"
        data['00000005']="����5"
    //�����ӥ�������
    }else if(place=="service"){
        if(display_flg == true){
            var name = "f_service"+num+"[name]";
        }else{
            var name = "f_service[name]";
        }
        data = new Array(5);
        data['0001']="�����ӥ�A"
        data['0002']="�����ӥ�B"
        data['0003']="�����ӥ�C"
        data['0004']="�����ӥ�D"
        data['0005']="�����ӥ�E"
    //�����ȼԥ�����
    }else if(place=="forwarding"){
        if(display_flg == true){
            var name = "f_forwarding"+num+"[name]";
        }else{
            var name = "f_forwarding[name]";
        }
        data = new Array(5);
        data['000001']="��˹����"
        data['000002']="�������"
        data['000003']="�����̱�"
        data['000004']="��ޥȱ�͢"
        data['000005']="�������"
    //ľ���襳����
    }else if(place=="direct"){
        if(display_flg == true){
            var name = "f_direct"+num+"[name]";
        }else{
            var name = "f_direct[name]";
        }
        data = new Array(5);
        data['000001']="ľ����A"
        data['000002']="ľ����B"
        data['000003']="ľ����C"
        data['000004']="ľ����D"
        data['000005']="ľ����E"
    //�϶襳����
    }else if(place=="area"){
        if(display_flg == true){
            var name = "f_area"+num+"[name]";
        }else{
            var name = "f_area[name]";
        }
        data = new Array(5);
        data['0001']="�̳�ƻ"
        data['0002']="����"
        data['0003']="����"
        data['0004']="����"
        data['0005']="�쳤"
    //�ܵҶ�ʬ������
    }else if(place=="client"){
        if(display_flg == true){
            var name = "f_client"+num+"[name]";
        }else{
            var name = "f_client[name]";
        }
        data = new Array(5);
        data['0001']="�ܵҶ�ʬA"
        data['0002']="�ܵҶ�ʬB"
        data['0003']="�ܵҶ�ʬC"
        data['0004']="�ܵҶ�ʬD"
        data['0005']="�ܵҶ�ʬE"
    //�����襳����
    }else if(place=="claim"){
        if(display_flg == true){
            var name = "f_claim"+num+"[name]";
        }else{
            var name = "f_claim[name]";
        }
        data = new Array(5);
        data['00000001']="������A"
        data['00000002']="������B"
        data['00000003']="������C"
        data['00000004']="������D"
        data['00000005']="������E"
    //�����ʬ������
    }else if(place=="dealing"){
        if(display_flg == true){
            var name = "f_dealing"+num+"[name]";
        }else{
            var name = "f_dealing[name]";
        }
        data = new Array(5);
        data['01']="�����ʬA"
        data['02']="�����ʬB"
        data['03']="�����ʬC"
        data['04']="�����ʬD"
        data['05']="�����ʬE"
    //ô���ԥ�����
    }else if(place=="charge"){
        if(display_flg == true){
            var name = "f_charge"+num+"[name]";
        }else{
            var name = "f_charge[name]";
        }
        data = new Array(5);
        data['0001']="���ô��A"
        data['0002']="���ô��B"
        data['0003']="���ô��C"
        data['0004']="���ô��D"
        data['0005']="���ô��E"
    //ʬ���ʬ������
    }else if(place=="kind"){
        if(display_flg == true){
            var name = "f_kind"+num+"[name]";
        }else{
            var name = "f_kind[name]";
        }
        data = new Array(5);
        data['0001']="��ԡ���"
        data['0002']="����"
        data['0003']="��󥿥�"
        data['0004']="�꡼��"
        data['0005']="��"
        data['0006']="����"
        data['0007']="����¾"
        data['0008']="�ݸ��ʽ�����"
        data['0009']="�ݸ������)"
        data['0010']="�ݸ��ʶ���)"
    //����������
    }else if(place=="close"){
        if(display_flg == true){
            var name = "f_close"+num+"[name]";
        }else{
            var name = "f_close[name]";
        }
        
        data = new Array(33);
        len = code.value.length;
        if(2==len && code.value>=1 && code.value<=30 && code.value!=null){
            data[code.value]="�̾�����";
        }
        data['31']="��������";
        data['91']="����������";
        data['99']="�������";
    }

    var data = data[code.value];
    
    for(var d=0;d<document.dateForm.elements.length;d++){
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data; 
            }
        }
    }
}
//"����"���
//��ԥ�����
function display1(code,place){
    if(place=="bank"){
        var name = "f_bank[name]";
        var num = "f_bank[num]";
    }else{
        var name = "t_"+place;
        var num = "n_"+place;
    }
    data = new Array(5);
    data['0001'] = new Array("�������ԡ���ë��Ź","00000000000001");
    data['0002'] = new Array("�ߤ��۶��","00000000000002");
    data['0003'] = new Array("���潻ͧ���","00000000000003");
    data['0004'] = new Array("UFJ���","00000000000004");
    data['0005'] = new Array("�������ԡ����ͻ�Ź","00000000000005");

    var data = data[code.value];
    
    for(var d=0;d<document.dateForm.elements.length;d++){
        //���̾��ɽ��
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data[0]; 
            }
        }
        //�ƽХ����ɤ�ɽ��
        if(document.dateForm.elements[d].name == num){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data[1]; 
            }
        }
    }
}
//�����襳����
function display2(code,place){
    var name = "t_"+place;
    data = new Array(5);
    data['00000001']="������A"
    data['00000002']="������B"
    data['00000003']="������C"
    data['00000004']="������D"
    data['00000005']="������E"
    var data = data[code.value];
    
    for(var d=0;d<document.dateForm.elements.length;d++){
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data; 
            }
        }
    }
}
//�����ʬ������
function display3(code,place){
    var name = "t_"+place;
    data = new Array(5);
    data['01']="�����ʬA"
    data['02']="�����ʬB"
    data['03']="�����ʬC"
    data['04']="�����ʬD"
    data['05']="�����ʬE"

    var data = data[code.value];
    
    for(var d=0;d<document.dateForm.elements.length;d++){
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data; 
            }
        }
    }
}
//���ʥ�����
function display4(code,place){
    var name = "t_"+place;
    data = new Array(5);
    data['00000001']="����1"
    data['00000002']="����2"
    data['00000003']="����3"
    data['00000004']="����4"
    data['00000005']="����5"
    var data = data[code.value];
    
    for(var d=0;d<document.dateForm.elements.length;d++){
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data; 
            }
        }
    }
}
//�����襳����
function display5(code,place){
    var name = "t_"+place;
    data = new Array(5);
    data['000001']="�������鹩��"
    data['000002']="��ե�"
    data['000003']="���եѥ���"
    data['000004']="��顼"
    data['000005']="�ꥨ��"
    var data = data[code.value];
    
    for(var d=0;d<document.dateForm.elements.length;d++){
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data; 
            }
        }
    }
}
//ô���ԥ�����
function display6(code,place){
    var name = "t_"+place;
    data = new Array(5);
    data['0001']="���ô��A"
    data['0002']="���ô��B"
    data['0003']="���ô��C"
    data['0004']="���ô��D"
    data['0005']="���ô��E"
    var data = data[code.value];
    
    for(var d=0;d<document.dateForm.elements.length;d++){
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data; 
            }
        }
    }
}
//�����ӥ�������
function display7(code,place){
    var name = "t_"+place;
    data = new Array(5);
    data['0001']="�����ӥ�A"
    data['0002']="�����ӥ�B"
    data['0003']="�����ӥ�C"
    data['0004']="�����ӥ�D"
    data['0005']="�����ӥ�E"
    var data = data[code.value];
    
    for(var d=0;d<document.dateForm.elements.length;d++){
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data; 
            }
        }
    }
}
//�Ҹ˥�����
function display8(code,place){
    var name = "t_"+place;
    data = new Array(5);
    data['001']="A�Ҹ�"
    data['002']="B�Ҹ�"
    data['003']="C�Ҹ�"
    data['004']="D�Ҹ�"
    data['005']="E�Ҹ�"
    var data = data[code.value];
    
    for(var d=0;d<document.dateForm.elements.length;d++){
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data; 
            }
        }
    }
}
//ʬ���ʬ������
function display9(code,place){
    var name = "t_"+place;
    data = new Array(10);
    data['0001']="��ԡ���"
    data['0002']="����"
    data['0003']="��󥿥�"
    data['0004']="�꡼��"
    data['0005']="��"
    data['0006']="����"
    data['0007']="����¾"
    data['0008']="�ݸ��ʽ�����"
    data['0009']="�ݸ������)"
    data['0010']="�ݸ��ʶ���)"
    var data = data[code.value];

    for(var d=0;d<document.dateForm.elements.length;d++){
        if(document.dateForm.elements[d].name == name){
            if(data == undefined){
                document.dateForm.elements[d].value = "";
            }else{
                document.dateForm.elements[d].value = data; 
            }
        }
    }
}

//*********************���֥�����ɥ�ɽ��****************************

//���̥�����ɥ��ǰ�����ɽ��
//������󥯤�����å����줿��硢�̥�����ɥ��ǰ�����ɽ������
function WindowOpen(fName,yoko,tate,name){
    var objWnd = null;
    Setup='width='+ yoko +',height='+ tate +',scrollbars=yes,resizable=yes';
    objWnd = window.open(fName,name,Setup);
    //���̤�����̤�ɽ��
    objWnd.focus();
}

//������ɥ����Ĥ���
function WindowClose(){
    window.close();
}

//*********************�ƥ����Ȥ�value���ѹ�*************************

function whileday(me,num){
    var D = "f_day_wh"+num+"[d_input]";
    var DAY = "f_text2_"+num;
    //�������Ϥ���Ƥ��뤫
    if(me.elements[D].value != "" && me.elements[D].value.length == "2"){
        me.elements[DAY].value = me.elements[D].value;
    }else{
        me.elements[DAY].value = "";
    }
}

//�ե����������ˡ����ߤ����դ�ɽ������
function onForm2(which,me,num){
    if (document.all || document.getElementById){
        which.style.backgroundColor="#FDFD66"
    }
    today       = new Date();
    Year    = today.getYear();
    Month   = today.getMonth()+1;
    Day     = today.getDate();
    var Y = "f_date_a"+num+"[y_input]";
    var M = "f_date_a"+num+"[m_input]";
    var D = "f_date_a"+num+"[d_input]";
    //�������Ϥ���Ƥ��뤫
    if(me.elements[Y].value == "" && me.elements[M].value == "" && me.elements[D].value == ""){
        me.elements[Y].value = Year;
        me.elements[M].value = Month;
        me.elements[D].value = Day;
        //���ʤ�0���դ���
        if(me.elements[M].value <= 9){
                me.elements[M].value = "0" + Month;
        }
        if(me.elements[D].value <= 9){
                me.elements[D].value = "0" + Day;
        }
    }
}

// �ե��������������������դ�ɽ��
function Comp_Form_NextToday(which, me, form, form_y, form_m, form_d){

    // �ե����������ϥե�����ο����Ѥ���
    if (document.all || document.getElementById){
        which.style.backgroundColor="FDFD66"
    }

    today = new Date();
    today.setDate(today.getDate() + 1);
    Year  = today.getYear();
    Month = today.getMonth()+1;
    Day   = today.getDate();
    var Y = form+"["+form_y+"]";
    var M = form+"["+form_m+"]";
    var D = form+"["+form_d+"]";

    // ���Ͼ��֤ʤ������䴰
    if (me.elements[Y].value == "" && me.elements[M].value == "" && me.elements[D].value == ""){
        me.elements[Y].value = Year;
        me.elements[M].value = Month;
        me.elements[D].value = Day;

        // 1��ʤ�0���
        if (me.elements[M].value <= 9){
            me.elements[M].value = "0" + Month;
        }
        if (me.elements[D].value <= 9){
            me.elements[D].value = "0" + Day;
        }
    }

}

//��������������ˤ�ɽ��
function setText1(me,num){
    var Y = "f_date_a"+num+"[y_input]";
    var M = "f_date_a"+num+"[m_input]";
    var S = "f_date_a96[y_input]";

    //�ƥ����Ȥ�ʸ��������
    me.elements[S].value = me.elements[Y].value;

    len = me.elements[Y].value.length;
    if( 4==len){
        me.elements[M].focus();
    }
}

function setText2(me,num){
    var M = "f_date_a"+num+"[m_input]";
    var D = "f_date_a"+num+"[d_input]";
    var S = "f_date_a96[m_input]";

    //�ƥ����Ȥ�ʸ��������
    me.elements[S].value = me.elements[M].value;

    len = me.elements[M].value.length;
    if (2<=len){
        me.elements[D].focus();
    }
}
function setText3(me,num){
    var D = "f_date_a"+num+"[d_input]";
    var S = "f_date_a96[d_input]";

    //�ƥ����Ȥ�ʸ��������
    me.elements[S].value = me.elements[D].value;

}

// �ե���������Ϥ��줿���оݤΥե������ʸ������䴰
function Comp_Form_Val(me, form, form1, form2, val){

    var form1 = form+"["+form1+"]";
    var form2 = form+"["+form2+"]";
    if ((me.elements[form1].value != "") && (me.elements[form2].value == "")){
//    if (me.elements[form2].value == ""){
    me.elements[form2].value = val;
    }

}

// �ե����������˸��ߤ����դ��䴰(ǯ�����ե�����)
function Comp_Form_Today(which, me, form, form_y, form_m, form_d){

    // �ե����������ϥե�����ο����Ѥ���
    if (document.all || document.getElementById){
        which.style.backgroundColor="#E6FFEC"
    }

    today = new Date();
    Year  = today.getYear();
    Month = today.getMonth()+1;
    Day   = today.getDate();
    var Y = form+"["+form_y+"]";
    var M = form+"["+form_m+"]";
    var D = form+"["+form_d+"]";

    // ���Ͼ��֤ʤ������䴰
    if (me.elements[Y].value == "" && me.elements[M].value == "" && me.elements[D].value == ""){
        me.elements[Y].value = Year;
        me.elements[M].value = Month;
        me.elements[D].value = Day;

        // 1��ʤ�0���
        if (me.elements[M].value <= 9){
            me.elements[M].value = "0" + Month;
        }
        if (me.elements[D].value <= 9){
            me.elements[D].value = "0" + Day;
        }
    }

}

//*********************onChange��submit*************************

//onChange��submit
function Change_Submit(hidden_form, page, str,next_value){
    //�ե��������褬NULL�ξ��ϡ�submit���ʤ�
    if(document.dateForm.elements[next_value].value != ""){
        var hdn = hidden_form;
        document.dateForm.elements[hdn].value = str;

        //Ʊ��������ɥ������ܤ���
        document.dateForm.target="_self";

        //�����̤����ܤ���
        document.dateForm.action=page;

        //POST�������������
        document.dateForm.submit();
    }
    return true;
}

//��˥塼�Υץ������
function Change_Menu(me,name){
    document.dateForm.target="_self";
    //�ץ��������ͤ�����������
    page = me.elements[name].value;
    //�����褬���ä�������submit
    if(page != "" && page != 'menu'){
        location.href = page;
    }
}

//*********************button��submit*************************

//onChange�ˤ�ä��̲��̤�POST����
function Change_Page(me,name){
    document.dateForm.target="_self";
    //�ץ��������ͤ�����������
    page = me.elements[name].value;
    //�����̤����ܤ���
    document.dateForm.action=page;
    //POST�������������
    document.dateForm.submit();
}

// button��submit
function Button_Submit(hidden_form, page, str){

    var hdn = hidden_form;
    document.dateForm.elements[hdn].value = str;

    //Ʊ��������ɥ������ܤ���
    document.dateForm.target="_self";

    //�����̤����ܤ���
    document.dateForm.action=page;

    //POST�������������
    document.dateForm.submit();

    return true;
}

// button��submit
function Button_Submit_1(hidden, page, str){
    var hdn = hidden;
    document.dateForm.elements[hdn].value = str;
    //Ʊ��������ɥ������ܤ���
    document.dateForm.target="_self";
    //�����̤����ܤ���
    document.dateForm.action=page;
    //POST�������������
    document.dateForm.submit();
}

//�̲��̤�POST������˻���
function Submit_Page(page){
    document.dateForm.target="_self";
    //�����̤����ܤ���
    document.dateForm.action=page;
    //POST�������������
    document.dateForm.submit();
}

function Submit_Page2(page){
    document.dateForm.target="_self";
    //�����̤����ܤ���
    document.dateForm.action=page;
    //POST�������������
    document.dateForm.submit();
    return false;
}

//*********************link��submit*************************
function Link_Submit(name,hidden, page, str){
    if(document.dateForm.elements[name].checked == true){
        document.dateForm.elements[hidden].value = str;
    }else {
        document.dateForm.elements[hidden].value = "";
    }
    //Ʊ��������ɥ������ܤ���
    document.dateForm.target="_self";
    //�����̤����ܤ���
    document.dateForm.action=page;
    //POST�������������
    document.dateForm.submit();
}

//**************���Ϸ��������̤�Ģɼ���Ȥ߹�碌�ξ��˻���********
function Submit_Judge(hidden_form, page1, page2, str){
    var hdn = hidden_form;
    var type = 'form_output_type';

        document.dateForm.elements[hdn].value = str;

        //Ʊ��������ɥ������ܤ���
        document.dateForm.target="_self";

        if(document.dateForm.elements[type][0].checked == true){
            //�����̤����ܤ���
            document.dateForm.action=page1;
        }else{
            document.dateForm.action=page2;
        } 

        //POST�������������
        document.dateForm.submit();
        
}

//**************Ģɼ��POST���������********
function Post_book_vote(page,next){
    //�̲��̤ǥ�����ɥ��򳫤�
    document.dateForm.target="_blank";
    document.dateForm.action=page;
    //POST�������������
    document.dateForm.submit();

    //�����̤Ǥ�SUBMIT���������
    if(next != undefined){
        document.dateForm.target="_self";
        document.dateForm.action=next;
        document.dateForm.submit();
    }
}

function Post_book_vote2(str_check,hidden,page,next,check_name,num){
    // ��ǧ����������ɽ��
    res = window.confirm(str_check+"\n��������Ǥ�����");
    // ����ʬ��
    if (res == true){
        document.dateForm.elements[hidden].value = true;

        //�����̤Ǥ�SUBMIT���������
        if(next != undefined){
            document.dateForm.target="_self";
            document.dateForm.action=next;
            document.dateForm.submit();
        }

        //ȯ�Ԥ�����ɼ�����򤵤�Ƥ��뤫Ƚ��
        for(var i=0;i<num;i++){
            var form_name = check_name+"["+i+"]";
            if(document.dateForm.elements[form_name].checked == true){
                var check_flg = true;
            }
        }

        //��ɼ�����򤵤�Ƥ������˥ե�����򳫤�
        if(check_flg == true){
            //�̲��̤ǥ�����ɥ��򳫤�
            document.dateForm.target="_blank";
            document.dateForm.action=page;
            //POST�������������
            document.dateForm.submit();
        }

        return true;
    }else{
        return false;
    }
}

//**************ͽ�ꥫ�������ѥڡ������ؤ�*********

//�������
function Jump_Page(page){
    if(page==1){
        location.href = "./2-2-101.php";
    }else if(page==2){
        location.href = "./2-2-101-2.php";
    }else if(page==3){
        location.href = "./2-2-101-3.php";
    }

    return false;
}
function Jump_Page2(page){
    if(page==1){
        location.href = "./2-2-102.php";
    }else if(page==2){
        location.href = "./2-2-102-2.php";
    }else if(page==3){
        location.href = "./2-2-102-3.php";
    }

    return false;
}

//*****************����������ɽ��*********************

/* 
 * �������֥�����ɥ��������������ɽ��
 * url:���֥�����ɥ���URL
 * arr:�ǡ����������ե������name�������
 * x:���֥�����ɥ��β���
 * y:���֥�����ɥ��ν���
 * display:���ʥ����������μ����ֹ�
 * select_id:�Ҹ�ID or ê��Ĵ��ID
 * shop_aid:����å׼���ID
 * place:���̾�Υ����
 * head_flg:����Ƚ��
 */
function Open_SubWin(url, arr, x, y,display,select_id,shop_aid,place,head_flg)
{
    //���������������ꤵ��Ƥ�����ϡ��Ҹ�ID or ê��Ĵ��ID ��ɬ��
    if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){

        //����ޥ����ξ�������Ƚ��
        if((display==6 || display==7 || display=='1-3-207') && head_flg != undefined){
            //�����ʬ���̾�ʳ��ϡ������ξ��ʤ�����ɽ��
            if(document.dateForm.elements[head_flg][0].checked != true){
                //����饤�󡦥��ե饤�����
                rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,true);
            }else{
                //�̾�
                rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,false);
            }
        }else{
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid);
        }

        if(typeof(rtnarr) != "undefined"){
            for(i=0;i<arr.length;i++){
                dateForm.elements[arr[i]].value=rtnarr[i];
            }
        }

        //ȯ�����ϡ��������Ϥξ���submit����
        if(display==2 || display==5 || display=='3-403' || display=='2-503' || display=='3-207' || display==1 || display=='true' || display=='2-409' || display=='2-405'){
            var next = '#';
            document.dateForm.action=next;
            document.dateForm.submit();
        }

        //����ޥ����ξ��ϲ��̤Υ�����submit����
        if(display==6 || display==7 || display=='1-3-207'){
            var next = '#'+place;
            document.dateForm.action=next;
            document.dateForm.submit();
        }

    }else{
        alert("�Ҹˤ����򤷤Ƥ���������");
    }
    return false;
}

function Open_SubWin_3(url, arr, x, y, display, select_id, row_num)
{
    //���������������ꤵ��Ƥ�����ϡ��Ҹ�ID or ê��Ĵ��ID ��ɬ��
    if ((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){

        rtnarr = Open_Dialog(url, x, y, display, select_id);

        if (typeof(rtnarr) != "undefined"){
            for(i=0;i<arr.length;i++){
                dateForm.elements[arr[i]].value=rtnarr[i];
            }
        }

        var next = '#'+row_num;
        document.dateForm.action=next;
        document.dateForm.submit();

    }

    return false;
}

//�����ܥ��󲡲���
function Open_SubWin_2(url, arr, x, y,display,select_id,shop_aid,next_page){
    rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid);
    if(typeof(rtnarr) != "undefined"){
        for(i=0;i<arr.length;i++){
            dateForm.elements[arr[i]].value=rtnarr[i];
        }
    }
    document.dateForm.target="_self";
    document.dateForm.action='#'+next_page;
    document.dateForm.submit();
    return false;
}

/* 
 * Open_SubWin�ν�����Ʊ���������㤦�Ȥ����ϡ��������������֤��ͤ��֤�
 * url:���֥�����ɥ���URL
 * arr:�ǡ����������ե������name�������
 * x:���֥�����ɥ��β���
 * y:���֥�����ɥ��ν���
 * display:���ʥ����������μ����ֹ�
 * select_id:�Ҹ�ID or ê��Ĵ��ID
 * shop_aid:����å׼���ID
 */
function Open_Contract(url, arr, x, y,display,select_id,shop_aid)
{
    //���������������ꤵ��Ƥ�����ϡ��Ҹ�ID or ê��Ĵ��ID ��ɬ��
    if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){
        rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid);
        if(typeof(rtnarr) != "undefined"){
            for(i=0;i<arr.length;i++){
                dateForm.elements[arr[i]].value=rtnarr[i];
            }
        }else{
            //�����������򥭥�󥻥뤷�����ϡ�hidden���֤��ͤ�����
            rtnarr = new Array("","","","get");
            for(i=0;i<arr.length;i++){
                dateForm.elements[arr[i]].value=rtnarr[i];
            }
        }

        //ȯ�����ϡ��������Ϥξ���submit����
        if(display==2 || display==5 || display==6){
            var next = '#';
            document.dateForm.action=next;
            document.dateForm.submit();
        }

    }else{
        alert("�Ҹˤ����򤷤Ƥ���������");
    }
    return false;
}


//���ʥ����������ؿ�
//FC��ͽ�ꡢ��夢����ǻȤäƤޤ�
function Open_SubWin_Plan(url, arr, x, y,display,select_id,shop_aid,place,head_flg)
{
    //���������������ꤵ��Ƥ�����ϡ��Ҹ�ID or ê��Ĵ��ID ��ɬ��
    if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){

        //�����ʬ���̾�ʳ��ϡ������ξ��ʤ�����ɽ��
        if(head_flg != 1){
            //����饤�󡦥��ե饤�����
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,true);
        }else{
            //�̾�
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,false);
        }

        if(typeof(rtnarr) != "undefined"){
            for(i=0;i<arr.length;i++){
                dateForm.elements[arr[i]].value=rtnarr[i];
            }
        }

        //����ޥ����ξ��ϲ��̤Υ�����submit����
        if(display==6 || display==7){
            var next = '#'+place;
            document.dateForm.action=next;
            document.dateForm.submit();
        }

    }

    return false;
}


/**
 * �ƥ�����ɥ������Ǥ��ʤ����Υ���������
 * @param   {url}       string      �����������˳����ե�����
 * @param   {x}         int         ��������������
 * @param   {y}         int         �����������ι⤵
 * @param   {display}   string      ������������GET���Ϥ�����(���ʥ����������μ����ֹ�)
 * @param   {select_id} string      ������������GET���Ϥ�����(�Ҹ�ID or ê��Ĵ��ID)
 * @param   {shop_aid} string       ������������GET���Ϥ�����(����å׼���ID)
 * @param   {head_flg} string       ������������GET���Ϥ�����(�������̥ե饰)
 * @return  {num}       mixed       ����������������͡ʶ��餯�����
 * @version
 * @author
 */
function Open_Dialog(url,x,y,display,select_id,shop_aid,head_flg){

    //�����������μ��ब���ꤵ��Ƥ��뤫
    if(display == undefined){
        num = showModalDialog(url,window,"status:no;dialogWidth:"+x+"px;dialogHeight:"+y+"px;edge:raised;help:no;resizable:yes;dialogTop:10px;dialogLeft:500px;");
    }else{
        //���ꤷ��������������ɽ��
        num = showModalDialog(url+"?display="+display+"&select_id="+select_id+"&shop_aid="+shop_aid+"&head_flg="+head_flg,window,"status:no;dialogWidth:"+x+"px;dialogHeight:"+y+"px;edge:raised;help:no;resizable:yes;dialogTop:10px;dialogLeft:500px;");
    }
    
    return num;
}


/**
 * �ƥ�����ɥ������Ǥ������Υ���������
 * @param   {url}       string      �����������˳����ե�����
 * @param   {x}         int         ��������������
 * @param   {y}         int         �����������ι⤵
 * @return  {num}       object      window���֥������Ȥ��֤�
 * @version
 * @author
 */
function Open_mlessDialog(url,x,y){
    num = showModelessDialog(url,window,"status:no;dialogWidth:"+x+"px;dialogHeight:"+y+"px;edge:raised;help:no;resizable:yes;dialogTop:10px;dialogLeft:500px;");
    
    return num;
}

/**
 * �ƥ�����ɥ������Ǥ������Υ���������
 * @param   {url}       string      �����������˳����ե�����
 * @param   {x}         int         ��������������
 * @param   {y}         int         �����������ι⤵
 * @return  {num}       object      window���֥������Ȥ��֤�
 * @version
 * @author
 */
function Open_submitDialog(url,x,y,hidden){
    num = showModalDialog(url,window,"status:no;dialogWidth:"+x+"px;dialogHeight:"+y+"px;edge:raised;help:no;resizable:yes;");
    if(num != null){
    var hdn = hidden;
        document.dateForm.elements[hdn].value = num;
        document.dateForm.target='_top';
        document.dateForm.action='#';
        document.dateForm.submit();
    }
}

/**
 * �ƥ�����ɥ������Ǥ������Υ���������(GET����ޤ�)
 * @param   {url}        string      �����������˳����ե�����
 * @param   {x}          int         ��������������
 * @param   {y}          int         �����������ι⤵
 * @param   {select_id}  string      ������������GET���Ϥ�����
 * @param   {select_id2} string      ������������GET���Ϥ�����
 * @return  {num}        object      window���֥������Ȥ��֤�
 * @param   {select_id3} string      ������������GET���Ϥ�����
 * @version
 * @author
 */
function Open_mlessDialmg_g(url,select_id,select_id2,x,y,select_id3){
    num = showModelessDialog(url+"?select_id="+select_id+"&select_id2="+select_id2+"&select_id3="+select_id3,window,"status:no;dialogWidth:"+x+"px;dialogHeight:"+y+"px;edge:raised;help:no;resizable:yes;dialogTop:10px;dialogLeft:500px;");
    
    return num;
}

/* 
 * �������֥�����ɥ��������������ɽ��
 * url:���֥�����ɥ���URL
 * arr:�ǡ����������ե������name�������
 * x:���֥�����ɥ��β���
 * y:���֥�����ɥ��ν���
 * display:���ʥ����������μ����ֹ�
 * select_id:�Ҹ�ID or ê��Ĵ��ID
 * shop_aid:����å׼���ID
 * place:���̾�Υ����
 * head_flg:����Ƚ��(�����ξ��ϡ�hidden�ΰ�value�ͤ�ߤ�)
 */
function Open_Detail(url, arr, x, y,display,select_id,shop_aid,place,head_flg)
{
    //���������������ꤵ��Ƥ�����ϡ��Ҹ�ID or ê��Ĵ��ID ��ɬ��
    if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){
        
        //����ޥ����ξ�������Ƚ��
        if((display==6 || display==7) && head_flg != undefined){
            //�����ʬ���̾�ʳ��ϡ������ξ��ʤ�����ɽ��
            if(document.dateForm.elements[head_flg][0].checked != true){
                //����饤�󡦥��ե饤�����
                rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,true);
            }else{
                //�̾�
                rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,false);
            }
        }else{
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid);
        }

        if(typeof(rtnarr) != "undefined"){
            for(i=0;i<arr.length;i++){
                dateForm.elements[arr[i]].value=rtnarr[i];
            }
        }

        //ȯ�����ϡ��������Ϥξ���submit����
        if(display==2 || display==5 || display==1){
            var next = '#';
            document.dateForm.action=next;
            document.dateForm.submit();
        }

        //����ޥ����ξ��ϲ��̤Υ�����submit����
        if(display==6 || display==7){
            var next = '#'+place;
            document.dateForm.action=next;
            document.dateForm.submit();
        }

    }else{
        alert("�Ҹˤ����򤷤Ƥ���������");
    }
    return false;
}

//*****************��������Ͽ*********************

//��������Ͽ�θ�������
//���ɽ�����ϥƥ����ȥܥå���readonly
function Text_Disabled2(){
    document.dateForm.elements["form_account[price]"].disabled = true;
    document.dateForm.elements["form_account[rate]"].disabled = true;
    document.dateForm.elements["form_account[price]"].style.backgroundColor = "gainsboro";
    document.dateForm.elements["form_account[rate]"].style.backgroundColor = "gainsboro";
}

//��������Ͽ�θ�������
//�����å��ܥ���
//�����å���Ĥ���ȥƥ����ȥܥå��������ϤǤ����
function Check_Button2(n) {
    if(n==1){
        if(document.dateForm.elements["form_account[1]"].checked){
            document.dateForm.elements["form_account[price]"].disabled = false;
            document.dateForm.elements["form_account[price]"].style.backgroundColor = "white";
        }
        else{
            document.dateForm.elements["form_account[price]"].disabled = true;
            document.dateForm.elements["form_account[price]"].style.backgroundColor = "gainsboro";
        }
        document.dateForm.elements["form_account[2]"].checked = false;
        document.dateForm.elements["form_account[rate]"].disabled = true;
        document.dateForm.elements["form_account[rate]"].style.backgroundColor = "gainsboro";
    }
    else if(n==2){
        if(document.dateForm.elements["form_account[2]"].checked){
            document.dateForm.elements["form_account[rate]"].disabled = false;
            document.dateForm.elements["form_account[rate]"].style.backgroundColor = "white";
        }
        else{
            document.dateForm.elements["form_account[rate]"].disabled = true;
            document.dateForm.elements["form_account[rate]"].style.backgroundColor = "gainsboro";
        }
        document.dateForm.elements["form_account[1]"].checked = false;
        document.dateForm.elements["form_account[price]"].disabled = true;
        document.dateForm.elements["form_account[price]"].style.backgroundColor = "gainsboro";

    }else{
        document.dateForm.elements["form_account[1]"].checked = false;
        document.dateForm.elements["form_account[2]"].checked = false;
        document.dateForm.elements["form_account[price]"].disabled = true;
        document.dateForm.elements["form_account[rate]"].disabled = true;
        document.dateForm.elements["form_account[price]"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_account[rate]"].style.backgroundColor = "gainsboro";
    }

    return true;
}

//*********************����¾************************
//���ɽ������
function form_potision(height){
    window.scrollTo(0,height);
}

//���ե�����˿���Ĥ���������᤹
//input������ˡ�onFocus="onForm(this)" onBlur="blurForm(this)"�פΤ褦�ˤ���
function onForm(which){
    if (document.all || document.getElementById){
        which.style.backgroundColor="#FDFD66"
    }
}

//�ե�����ο����᤹
function blurForm(which){
    if (document.all || document.getElementById){
        which.style.backgroundColor="#FFFFFF"
    }
}

function fontColor(which){
    if(which.value < 0){ 
        which.style.color="red"
    }else{
        which.style.color="black"
    }
}
function dayweek(me,num){
    week = new Array('7','1','2','3','4','5','6');
    var Y = "f_day_w"+num+"[y_input]";
    var M = "f_day_w"+num+"[m_input]";
    var D = "f_day_w"+num+"[d_input]";
    var DAY = "f_text1_"+num;
    //�������Ϥ���Ƥ��뤫
    if(me.elements[Y].value != "" && me.elements[M].value != "" && me.elements[D].value != "" && me.elements[Y].value.length == "4" && me.elements[M].value.length == "2" && me.elements[D].value.length == "2" && me.elements[M].value > 0 && me.elements[M].value < 13 && me.elements[D].value > 0 && me.elements[D].value < 32){
        target = new Date();
        target.setFullYear(me.elements[Y].value);
        target.setMonth(me.elements[M].value -1);
        target.setDate(me.elements[D].value);
        me.elements[DAY].value = week[target.getDay()];
    }else{
        me.elements[DAY].value = "";
    }
}

function goods_search(code,hidden,row){
    var hdn = hidden;
    var len = code.value.length;
    if(len==8){
            document.dateForm.elements[hdn].value = row;
        //Ʊ��������ɥ������ܤ���
        document.dateForm.target="_self";
            //�����̤����ܤ���
        document.dateForm.action='#';
        document.dateForm.submit();
    }
}


function Link_Switch(url,x,y,client_id,select_id){
    var num = showModalDialog(url,window,"status:no;dialogWidth:"+x+"pt;dialogHeight:"+y+"pt;edge:raised;help:no");
    if(num==1){
        location.href = "../../../src/franchise/sale/2-2-107.php?aord_id="+select_id;
    }else if(num==2){
        location.href = "../../../src/franchise/system/2-1-115.php?client_id="+client_id+"&get_flg=cal";
    }else if(num==3){
        location.href = "../../../src/franchise/sale/2-2-108.php";
    }else if(num==4){
        location.href = "../../../src/franchise/system/2-1-114.php";
    }else if(num==5){
        location.href = "../../src/head/analysis/1-6-141.php";
    }

    return false;
}

function Link_Switch2(url,x,y,client_id,select_id){
    var num = showModalDialog(url,window,"status:no;dialogWidth:"+x+"pt;dialogHeight:"+y+"pt;edge:raised;help:no");
    if(num==1){
        location.href = "../../../src/franchise/sale/2-2-211.php?aord_id="+select_id;
    }else if(num==2){
        location.href = "../../../src/franchise/system/2-1-115.php?client_id="+client_id+"&get_flg=cal";
    }

    return false;
}

function Link_Switch3(url,x,y,client_id,select_id){
    var num = showModalDialog(url,window,"status:no;dialogWidth:"+x+"pt;dialogHeight:"+y+"pt;edge:raised;help:no");
    if(num==1){
        location.href = "../../../src/franchise/sale/2-2-202.php?sale_id="+select_id;
    }else if(num==2){
        location.href = "../../../src/franchise/system/2-1-115.php?client_id="+client_id+"&get_flg=cal";
    }

    return false;
}

function goods_search_1(me, name, hidden, row){
        //var ary =  name+"["+row+"]";
        var ary2=  hidden;
        //var len = me.elements[ary].value.length;
//        if(len==8 || len==null){
            me.elements[ary2].value = row;
            //Ʊ��������ɥ������ܤ���
            document.dateForm.target="_self";
            //�����̤����ܤ���
            document.dateForm.action='#';
            document.dateForm.submit();
//        }
}

function c_goods_search(me, name, hidden, row,place){
    var ary2=  hidden; 
    me.elements[ary2].value = row;
    //Ʊ��������ɥ������ܤ���
    document.dateForm.target="_self";
    //�����̤����ܤ���
    var next = '#'+place;
    document.dateForm.action=next;
    document.dateForm.submit();
}

//���ʥ��������Ͻ���
function goods_search_2(me, name, hidden, row, row_num){
    var ary =  name+"["+row+"]";
    var ary2=  hidden;
    var len = me.elements[ary].value.length;
    me.elements[ary2].value = row;
    document.dateForm.target="_self";
    document.dateForm.action='#'+row_num;
    document.dateForm.submit();
    return ary;
}


function sum(num){
    var A = "form_b_stock_num["+num+"]";
    var B = "form_adjust_num["+num+"]";
    var C = "form_a_stock_num["+num+"]";
    var D = "form_io_type["+num+"]";
    var E = "form_goods_cd["+num+"]";
    
    for (var i = 0; i < document.dateForm.elements[D].length; i++){
        if(document.dateForm.elements[D][i].checked == true){
            var kubun = document.dateForm.elements[D][i].value;
        }
    }
        
    if (document.dateForm.elements[E].value == ''){
        document.dateForm.elements[C].value = ''; 
        return false;
    }

    if(kubun == '1'){
        var count = (document.dateForm.elements[A].value) - (-(document.dateForm.elements[B].value));
    }else{
        var count = (document.dateForm.elements[A].value) - (document.dateForm.elements[B].value);
    }

    if(isNaN(count)==false ){
        document.dateForm.elements[C].value = count; 
    }
}


function price_amount(num){
    var A = "form_buy_price["+num+"][i]";
    var B = "form_buy_price["+num+"][d]";
    var C = "form_order_num["+num+"]";
    var D = "form_buy_amount["+num+"]";
    var E = "form_goods_cd["+num+"]";

    if(document.dateForm.elements[E].value = ''){
        document.dateForm.elements[D].value = '';
        return false;
    }else{

        var count = (document.dateForm.elements[C].value) * ((document.dateForm.elements[A].value)+(document.dateForm.elements[B].value)/10);

        if(isNaN(count) == false){
            document.dateForm.elements[D].value = count;
        }
    }
}
/**
 * �ڡ��������ȥ�Υơ��֥륵��������
 * @param   {void}      void
 * @return  {void}      void
 * @version 
 * @author  
 */
function WindowSizeChange(){
    //ID��page_title_table�Υơ��֥뤬���뤫��ǧ
    if(document.getElementById("page_title_table") != null){
        //IE�ѥ�����ɥ��������β�����������ڡ��������ȥ�ơ��֥륵��������
        if(document.all){
            document.all("page_title_table").style.width = document.body.clientWidth -50;
        //NN��FF�Ȥ��ѥ�����ɥ��������β�����������ڡ��������ȥ�ơ��֥륵��������
        }else if(document.getElementById){
            document.getElementById("page_title_table").style.width = window.innerWidth -50;
        }
    }
}
/*
window.onresize = WindowSizeChange;
window.onload = WindowSizeChange;
*/

//Enter������Tab�������֤�������
function chgKeycode(){ 

    if( window.event.keyCode == 0x0d ) 
    { 
        window.event.keyCode = 0x09; 
    } 

    return; 
} 

//��˥塼���˿������ɽ��
function Move_menu(){
    //�����׻�
    nWinWidth = document.body.scrollLeft;

    //�쥤�䡼�����ȹ⤵���ɸ�˥��å�
    menu.style.left = nWinWidth+19; 
    menu.style.top = 0;
    nTimer=setTimeout("Move_menu()",100);
}

//�̥�����ɥ���submit����
function Submit_Blank_Window(post_url,msg){
    if(Dialogue4(msg)){
        //�̥�����ɥ���submit����
        document.forms[0].target="_blank";
        document.forms[0].action=post_url;
        document.forms[0].submit();

        //submit��򼫲��̤��᤹
        document.forms[0].target="_self";
        document.forms[0].action=document.URL;
    }

}

//���Ϸ���(���̡�Ģɼ)��submit����ѹ�����
function Submit_If_Url(post_url,f_name){
        var name = f_name;

    //Ģɼ�˥����å���������ϡ�Ģɼ���̤�submit
    if(document.forms[0].elements[name][1].checked == true){
        Submit_Blank_Window(post_url,"Ģɼ����Ϥ��ޤ���")
        return false;

    //�����̤�submit
    }else{
        //document.forms[0].submit();
        return true;
    }
}

/**
 * 2��POST�ɻ�
 * �ܥ����input type=button�ǡ�submit���������
 * 
 * @param   {btn_name}      string      disabled�ˤ���ܥ���̾
 * @param   {hdn_name}      string      �ܥ������������Ф�hidden̾
 * @param   {hdn_value}     string      hidden�����Ф�value
 * 
 * @version
 * @author
 */
function Double_Post_Prevent(btn_name, hdn_name, hdn_value)
{

    var BN = btn_name;
    var HN = hdn_name;
    var HV = hdn_value;

    dateForm.elements[BN].disabled=true;
    dateForm.elements[HN].value=HV;
    dateForm.submit();

    return;

}


function Double_Post_Prevent2(me)
{

    var btn_name = me.name;
    var btn_val  = me.value;
    var hdn_name = btn_name.substr(4);

    me.disabled = true;
    document.forms[0].elements[hdn_name].value = btn_val;
    dateForm.submit();

    return;

}