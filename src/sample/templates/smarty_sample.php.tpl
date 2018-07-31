<html>
<head>
    <title>sample</title>
</head>
<body>
    ＊パターン１
    <table border="1" width="650">
    <tr bgcolor="red">
        <td>No.</td>
        <td>名前</td>
        <td>年齢</td>
        <td>貯金額</td>
    </tr>
    {*テンプレートに送られてきた配列要素分ループ*}
    {foreach from=$data item=item key=i}
    <tr>
        <td>{$i+1}</td>
        <td>{$data[$i][0]}</td>
        <td>{$data[$i][1]}　　歳</td>
        <td>{$data[$i][2]}　　万円</td>
    </tr>
    {/foreach}
    </table>
    <br>
    ＊パターン2    
    <table border="1" width="650">
    <tr bgcolor="blue">
        <td>No.</td>
        <td>名前</td> 
        <td>年齢</td> 
        <td>貯金額</td> 
    </tr>   
    {*テンプレートに送られてきた配列要素分ループ*}
    {foreach from=$data item=item key=i}
    <tr>    
        <td>{$i+1}</td>
        <td>{$item[0]}</td>
        <td>{$item[1]}　　歳</td> 
        <td>{$item[2]}　　万円</td> 
    </tr>   
    {/foreach}
    </table>
    <br>
    ＊パターン3
    <table border="1" width="650">
    <tr bgcolor="green">
        <td>No.</td>
        <td>名前</td>
        <td>年齢</td>
        <td>貯金額</td>
    </tr>   
    {*テンプレートに送られてきた配列要素分ループ*}    
    {*一次元目*}
    {foreach from=$data item=item key=i}
    <tr>
        <td>{$i+1}</td>
        {*二次元目*}
        {foreach from=$item item=items key=j}
            {if $j == 0}  
                <td>{$items}</td>
            {elseif $j == 1}
                <td>{$items}　　歳</td>
            {else}
                <td>{$items}　　万円</td>
            {/if}
        {/foreach}
    </tr>   
    {/foreach}
    </table>
</body>
</html>
