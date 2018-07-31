/**
 * @fileoverview    データ出力共通関数です。
 *
 * @author
 * @version
 *
 */


/**
 * フォーカス時に今年１月を補完(年月フォーム)
 * 
 * @param   {Object}    which       this
 * @param   {Object}    me          this.form
 * @param   {String}    form        親のフォーム名
 * @param   {String}    form_y      子のフォーム名（年）
 * @param   {String}    form_m      子のフォーム名（月）
 * @return  void
 * @type    void
 */
function Onform_Thisyear_Jan_YM(which, me, form, form_y, form_m) {

    // フォーカス時は背景色を変える
    if (document.all || document.getElementById) {
        which.style.backgroundColor = "#FDFD66";
    }

    // 設定
    today = new Date();
    Year  = today.getYear();
    Month = "01";
    var Y = form_y;
    var M = form_m;

    // 年・月ともに入力が無い場合
    if (me.elements[Y].value == "" && me.elements[M].value == ""){
        // 値をセット
        me.elements[Y].value = Year;
        me.elements[M].value = Month;
    }

}

/**
 * フォームに色をつける＆色を戻す
 * inputタグ内に「onFocus="onForm(this)" onBlur="blurForm(this)"」のようにする
 *
 * @param   {Object}    which       this  
 * @return  void 
 * @type    void
 */
function onForm(which){
    if (document.all || document.getElementById){
        which.style.backgroundColor="#FDFD66"
    }
}


/**
 * フォーカスが外れた際にフォームの色を戻す
 * 
 * @param   {Object}    which       this
 * @return  void
 * @type    void
 */
function blurForm(which) {

    if (document.all || document.getElementById){
        which.style.backgroundColor = "#FFFFFF";
    }

}


/**
 * EnterキーをTabキーへ置き換える
 * 
 * @param   void
 * @return  void
 * @type    void
 */
function chgKeycode() { 

    // Enterキーのキーコードイベントが発生した場合
    if (window.event.keyCode == 0x0d) { 
        // Tabキーのキーコードイベントへ変更
        window.event.keyCode = 0x09; 
    }

    return;
}


/**
 * フォーカス移動
 * 
 * @param   {Object}    me          this.form
 * @param   {String}    name        現在のフォーム
 * @param   {String}    next        フォーカスの移動先
 * @param   {Integer}   length      最大入力文字数
 * @param   {String}    val         ？
 * @return  void
 * @type    void
 */
function changeText(me, name, next, length, val) {

    // カレント、ネクストフォームを変数にセット
    var F1 = name;
    var F2 = next;

    // 引数が渡された場合
    if (val != undefined) {
        // ネクストフォームの値が空の場合
        if (me.elements[F2].value == "") {
            // 渡された引数をネクストフォームにセット
            me.elements[F2].value = val;
        }
    }

    // カレントフォームの入力文字数をカウント
    len = me.elements[F1].value.length;

    // カレントフォームの入力文字数が、任意の文字数を超えた場合
    if (length <= len) {
        // ネクストフォームへフォーカスを移動する
        me.elements[F2].focus();
    }

} 

/**********************TOP・SUBメニュー処理***************************/

//トップメニューがクリックされた場合は、クッキ情報を送る
//サブメニューがクリックされた場合は、引数にオブジェクトの"id"を設定することで、
//ツリー構造メニューの開閉を行う
//引数（メニュー項目,本部・FC識別,サブメニュー名,top・sub識別）
function TS_Menu(menu,where_menu,tName,ts_menu) {
    //本部・FC識別
    if(where_menu == 'head'){
         /******本部******/
         switch (menu){
             case 'sale':
                 data_menu = new Array("受注取引","売上取引","請求管理","入金管理","実績管理");
                 break;
             case 'buy':
                 data_menu = new Array("発注取引","仕入取引","支払管理","実績管理");
                 break;
             case 'stock':
                 data_menu = new Array("在庫取引","棚卸管理");
                 break;
             case 'renew':
                 data_menu = new Array("更新管理");
                 break;
             case 'system':
                 //data_menu = new Array("マスタ管理","システム設定");
                 data_menu = new Array("マスタ管理","帳票設定","システム設定");
                 break;
             case 'analysis':
                 data_menu = new Array("統計情報","月例販売精算書","CSV出力");
                 break;
             default:
         }
     }else{
     /******FC******/
         switch (menu){
             case 'sale':
                 data_menu = new Array("予定取引","売上取引","請求管理","入金管理","実績管理");
                 break;
             case 'buy':
                 data_menu = new Array("発注取引","仕入取引","支払管理","実績管理");
                 break;
             case 'stock':
                 data_menu = new Array("在庫取引","棚卸管理");
                 break;
             case 'renew':
                 data_menu = new Array("更新管理");
                 break;
             case 'system':
                 data_menu = new Array("マスタ管理","帳票設定","システム設定");
                 break;
             case 'analysis':
                 data_menu = new Array("統計情報","CSV出力");
                 break;
             default:
         }
     }
     //有効期限の計算をします。
     var today = new Date();
     today.setHours(today.getHours() + 1);

     //TOP・SUBメニュー判定
     if(ts_menu == "top"){
        //TopMenu処理
        //メニュー項目数分判別
         for(var i=0;i<data_menu.length;i++){
             var j = i + 1;
             var str = "history"+j;
             var str2 = "history_flg"+j;

             //展開されたメニューは何か
             if(tName == data_menu[i]){
                 //展開したメニュー名
                 document.cookie = str + "=" + j + "; expires=" + today.toGMTString() + ", path=/";
                 //展開・閉じる識別フラグ
                 document.cookie = str2 + "=" + 'true' + "; expires=" + today.toGMTString()+", path=/";
             }
         }
     }else{
         //SubMenu処理
         //スタイルオブジェクト取得
         tMenu = document.getElementById(tName).style;
         imgName = tName+'Img';

        //サブメニューがクリックされたか
        if(tMenu.display=='none'){
            //メニューを展開する
            tMenu.display='block';
            document.getElementById(imgName).src='../../../image/minus.png';
            //メニュー項目数分判別
            for(var i=0;i<data_menu.length;i++){
                var j = i + 1;
                var str = "history"+j;
                var str2 = "history_flg"+j;
                //展開されたメニューは何か
                if(tName == data_menu[i]){
                    //展開したメニュー名
                    document.cookie = str + "=" + j + "; expires=" + today.toGMTString() + ", path=/";
                    //展開・閉じる識別フラグ
                    document.cookie = str2 + "=" + 'true' + "; expires=" + today.toGMTString() + ", path=/";
                }
            }                                      
        }else{
            //メニューを閉じる
            tMenu.display='none';
            document.getElementById(imgName).src='../../../image/plus.png';
            for(var i=0;i<data_menu.length;i++){
                var j = i + 1;
                var str = "history"+j;
                var str2 = "history_flg"+j;
                //閉じられたメニューは何か
                if(tName == data_menu[i]){
                    document.cookie = str + "=" + j + "; expires=" + today.toGMTString() + ", path=/";
                    //展開・閉じる識別フラグ
                    document.cookie = str2 + "=" + 'false' + "; expires=" + today.toGMTString() + ", path=/";
                }
            }
        }
    }                       
}

//メニューのプルダウン
function Change_Menu(me,name){
    document.dateForm.target="_self";
    //プルダウンの値の遷移先を取得
    page = me.elements[name].value;
    //遷移先があった場合だけsubmit
    if(page != "" && page != 'menu'){
        location.href = page;
    }
}


