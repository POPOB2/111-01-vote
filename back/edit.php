
<!-- 編輯頁面 -->

<?php
$id=$_GET['id'];
$subj=find('subjects',$id);// findFunction 只找一筆資料
$opts=all('options',['subject_id'=>$id]);// allFunction 找全部資料
// dd($subj);
// dd($opts);


?>

<form action="./api/edit_vote.php" method="post">
    <div><!-- 新增分類管理選擇器------------------------------------------------------------------------- -->
            <select name="types" id="types">
                <?php
                $types=all("types");
                foreach($types as $type){
                    $selected=($subj['type_id']==$type['id'])?'selected':''; // 主題的subjects表type_id欄的值 == types表id欄的值時, 賦值selected 否則 空值
                    echo "<option value='{$type['id']}' $selected>"; // 使用者頁面看不到 實際傳到資料表的值, 新增selected字串 用於設為預設選項
                    echo $type['name']; // 使用者頁面看到的選項值
                    echo "</option>";
                }
                ?>
            </select>
    </div>

    <div>
        <label for="subject">投票主題：</label><!-- label的for可以使用id值做連接, 將下列的input用id連接後 兩者可以產生關聯 -->
        <input type="text" name="subject" id="subject" value="<?=$subj['subject'];?>"><!-- 第6行找到的資料用 值=$subj的資料表欄位['subject']內容  顯示 -->
        <input type="button" value="新增選項" onclick="more()"><!-- '每點一下'就會新增, 所以使用onclick去add -->
        <input type="hidden" name="subject_id" value="<?=$subj['id'];?>"><!-- 隱藏欄位subject_id, 送出時 到/api/edit_vote.php會顯示資料表subjects的id欄位內容 -->
        <!-- 用於定位資料表的id, 使這個表單在編輯更新時有id值的存在 用於判斷為更新 而非新增, 將更新完的文字 更新在該id的這筆資料上 -->
    </div>

    <div id="selector">
        <!-- $subj的multiple欄內容 == 0或1時 在該列 印出'checked'使編輯功能內的選項可以使用資料庫的multiple內容判斷, 當初這題是選單選還是複選 -->
        <input type="radio" name="multiple" value="0" <?=($subj['multiple']==0)?'checked':'';?>> 
        <label>單選</label>
        <input type="radio" name="multiple" value="1" <?=($subj['multiple']==1)?'checked':'';?>>
        <label>複選</label>
    </div>

    <div id="options">
        <?php
        foreach($opts as $opt){// 查找到的每一個選項內容(7行) as 作為一個資料內容呈現(40行) , 不須顯示值的索引值 所以不輸入$key只用$opt(內容)
        ?>
        <div>
            <!-- 顯示的值value=$opt(22行)options資料庫的option資料欄位的內容 -->
            <label>選項:</label><input type="text" name="option[<?=$opt['id'];?>]" value="<?=$opt['option'];?>">
            <!-- name="option[< ?=$option['id'];?>]"====用於讓option資料表 獲取該筆$opt資料表id 功能和20行的註解相同 -->
        </div>
        <?php
        }
        ?>
    </div>
    <input type="submit" value="修改">

</form>
<script>
    function more(){
        let opt=`<div><label>選項:</label><input type="text" name="option[]"></div>`;
        let opts=document.getElementById('options').innerHTML;// 變數opts=由id:options的內容賦值.使用innerHTML縮小查找與顯示該ID範圍
        opts=opts+opt;// 將opts再加上opt的內容(即click後的'新增選項'表單)
        document.getElementById('options').innerHTML=opts;
    }
</script>