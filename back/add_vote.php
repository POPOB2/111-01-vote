<form action="./api/add_vote.php" method="post">
    
    <div><!-- 新增分類管理選擇器------------------------------------------------------------------------- -->
        <select name="types" id="types">
            <?php
            $types=all("types");
            foreach($types as $type){
                echo "<option value='{$type['id']}'>"; // 使用者頁面看不到 實際傳到資料表的值
                echo $type['name']; // 使用者頁面看到的選項值
                echo "</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label for="subject">投票主題：</label> <!-- label的for可以使用id值做連接, 將下列的input用id連接後 兩者可以產生關聯 -->
        <input type="text" name="subject" id="subject">
        <input type="button" value="新增選項" onclick="more()"> <!-- '每點一下'就會新增, 所以使用onclick去add -->
    </div>
    <div id="selector">
        <input type="radio" name="multiple" value="0" checked> <!-- checked=預設, 給value 0或1 使subjects資料表的multiple欄 可以辨別單複選的選擇 -->
        <label>單選</label>
        <input type="radio" name="multiple" value="1">
        <label>複選</label>
    </div>
    <div id="options">
        <div>
            <label>選項:</label><input type="text" name="option[]"> <!-- 先在這獲取內容,再將17行的文字加進來 類似options=options+opt -->
            <!-- 這裡的name要加上[]框號 避免新增多個欄位時, 沒有產生陣列的索引分類這些name="option"
                 這會導致所有欄位都標記為name="option" 而導致不管新增幾個都會一直有新的option覆蓋舊的option 結果終究只有最後一個option(欄位)

                 *未加[]如下:
                  $a['options']=值(新增的第一個欄位)
                  $a['options']=值(新增的第二個欄位)
                  $a['options']=值(新增的第三個欄位)
                  因為只有一個options作為命名基準 所以結果為 只有 [option=>新增的第三個欄位]

                 *加了[]如下:
                  $a=options[0(新增的第一個欄位),1(新增的第二個欄位),2(新增的第三個欄位)]
                  將只有一個options作為空陣列的基準 所以後續新增的欄位都以索引 填入該options陣列
             -->

        </div>
    </div>
    <input type="submit" value="新增">

</form>
<script>
    function more(){
        let opt=`<div><label>選項:</label><input type="text" name="option[]"></div>`;
        let opts=document.getElementById('options').innerHTML; // 變數opts=由id:options的內容賦值.使用innerHTML縮小查找與顯示該ID範圍
        opts=opts+opt; // 將opts再加上opt的內容(即click後的'新增選項'表單)
        document.getElementById('options').innerHTML=opts;
    }
</script>